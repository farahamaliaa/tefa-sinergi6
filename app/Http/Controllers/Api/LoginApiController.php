<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    private StudentInterface $student;
    private EmployeeInterface $employee;

    public function __construct(StudentInterface $student, EmployeeInterface $employee)
    {
        $this->student = $student;
        $this->employee = $employee;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $fullDomain = request()->root();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken($request->email)->plainTextToken;
                return ResponseHelper::success([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->roles->first()->name,
                    'token' => $token,
                    'image' => match($user->roles->first()->name) {
                        'student' => $user->student && $user->student->image 
                            ? asset($fullDomain.'/storage/'.$user->student->image) 
                            : asset($fullDomain.'/public/admin_assets/dist/images/profile/user-1.jpg'),
                        'parent' => asset($fullDomain.'/public/admin_assets/dist/images/profile/user-1.jpg'),
                        default => $user->employee && $user->employee->image 
                            ? asset($fullDomain.'/storage/'.$user->employee->image) 
                            : asset($fullDomain.'/public/admin_assets/dist/images/profile/user-1.jpg'),
                    },
                ], 'Berhasil login');
            } else {
                return ResponseHelper::error('Email atau password salah', 401);
            }
        } else {
            return ResponseHelper::error('Email atau password salah', 401);
        }
    }

    public function user_detail(User $user)
    {
        $role = $user->roles->first()->name;
        
        if ($role == 'student') {
            $student = $this->student->whereUserId($user->id);
            if (!$student) return ResponseHelper::notFound('Data siswa tidak ditemukan');
            
            return ResponseHelper::success([
                'nisn' => $student->nisn,
                'class' => optional($student->classroomStudents()->latest()->first()->classroom)->name,
                'gender' => $student->gender->label(),
                'religion' => optional($student->religion)->name,
                'birth_date' => $student->birth_date ? Carbon::parse($student->birth_date)->format('d-m-Y') : null,
                'birth_place' => $student->birth_place,
                'number_kk' => $student->number_kk,
                'nik' => $student->nik,
                'order_child' => $student->order_child,
                'number_akta' => $student->number_akta,
                'count_siblings' => $student->count_siblings,
                'address' => $student->address,
            ]);
        } elseif ($role == 'parent') {
            $parent = \App\Models\Parents::where('user_id', $user->id)->first();
            return ResponseHelper::success([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $parent->phone ?? '-',
                'address' => $parent->address ?? '-',
                'role' => 'Wali Murid',
            ]);
        } else {
            $employee = $this->employee->getByUser($user->id);
            if (!$employee) return ResponseHelper::notFound('Data pegawai tidak ditemukan');
            
            return ResponseHelper::success([
                'nip' => $employee->nip,
                'birth_date' => $employee->birth_date ? Carbon::parse($employee->birth_date)->format('d-m-Y') : null,
                'nik' => $employee->nik,
                'phone_number' => $employee->phone_number,
                'address' => $employee->address,
                'religion' => optional($employee->religion)->name,
            ]);
        }
    }
}
