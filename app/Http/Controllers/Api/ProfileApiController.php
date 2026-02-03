<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Interfaces\EmployeeInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Parents;
use App\Models\Religion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileApiController extends Controller
{
    private StudentInterface $student;
    private EmployeeInterface $employee;

    public function __construct(StudentInterface $student, EmployeeInterface $employee)
    {
        $this->student = $student;
        $this->employee = $employee;
    }

    public function getProfile(User $user)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $role = $user->roles->first()->name;
        $fullDomain = request()->root();

        $baseData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $role,
        ];

        if ($role == 'student') {
            $student = $this->student->whereUserId($user->id);
            if (!$student) {
                return ResponseHelper::notFound('Data siswa tidak ditemukan');
            }

            return ResponseHelper::success(array_merge($baseData, [
                'image' => $student->image
                    ? asset($fullDomain . '/storage/' . $student->image)
                    : null,
                'nisn' => $student->nisn,
                'nik' => $student->nik,
                'gender' => $student->gender?->value,
                'gender_label' => $student->gender?->label(),
                'religion' => optional($student->religion)->name,
                'birth_date' => $student->birth_date,
                'birth_date_formatted' => $student->birth_date
                    ? Carbon::parse($student->birth_date)->format('d-m-Y')
                    : null,
                'birth_place' => $student->birth_place,
                'address' => $student->address,
                'number_kk' => $student->number_kk,
                'number_akta' => $student->number_akta,
                'order_child' => $student->order_child,
                'count_siblings' => $student->count_siblings,
                'classroom' => optional($student->classroomStudents()->latest()->first()->classroom)->name,
            ]));

        } elseif ($role == 'parent') {
            $parent = Parents::where('user_id', $user->id)->first();

            return ResponseHelper::success(array_merge($baseData, [
                'image' => $user->image
                    ? asset($fullDomain . '/storage/' . $user->image)
                    : null,
                'phone_number' => $parent->phone_number ?? null,
                'address' => $parent->address ?? null,
                'gender' => $user->gender,
                'gender_label' => $user->gender == 'male' ? 'Laki-laki' : ($user->gender == 'female' ? 'Perempuan' : '-'),
            ]));

        } else {
            $employee = $this->employee->getByUser($user->id);
            if (!$employee) {
                return ResponseHelper::notFound('Data pegawai tidak ditemukan');
            }

            // Fetch classroom name (Wali Kelas)
            $classroom = Classroom::where('employee_id', $employee->id)->first();
            $classroomName = $classroom ? $classroom->name : null;

            // Mapping for common technical positions to human readable
            $positionMapping = [
                'ketua_tu' => 'Ketua TU',
                'pembina_ekskul' => 'Pembina Ekskul',
            ];

            $position = optional($employee->employeePosition)->name
                ?? ($positionMapping[$employee->position]
                    ?? ucwords(str_replace('_', ' ', $employee->position)));

            return ResponseHelper::success(array_merge($baseData, [
                'image' => $employee->image
                    ? asset($fullDomain . '/storage/' . $employee->image)
                    : null,
                'nip' => $employee->nip,
                'nik' => $employee->nik,
                'gender' => $employee->gender?->value,
                'gender_label' => $employee->gender?->label(),
                'religion' => optional($employee->religion)->name,
                'birth_date' => $employee->birth_date,
                'birth_date_formatted' => $employee->birth_date
                    ? Carbon::parse($employee->birth_date)->format('d-m-Y')
                    : null,
                'birth_place' => $employee->birth_place,
                'phone_number' => $employee->phone_number,
                'address' => $employee->address,
                'position' => $position,
                'classroom' => $classroomName,
                'user_id' => $user->id,
                'employee_id' => $employee->id,
            ]));
        }
    }

    public function updateProfile(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $role = $user->roles->first()->name;

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        $updateData = $request->all();
        if ($request->has('religion')) {
            $religion = Religion::where('name', $request->religion)->first();
            if ($religion) {
                $updateData['religion_id'] = $religion->id;
            }
        }

        // Normalize gender if needed (Laki-laki -> male, Perempuan -> female)
        if ($request->has('gender')) {
            $g = strtolower($request->gender);
            if (strpos($g, 'laki') !== false || $g == 'male') {
                $updateData['gender'] = 'male';
            } elseif (strpos($g, 'perempuan') !== false || $g == 'female') {
                $updateData['gender'] = 'female';
            }
        }

        // Prepare data for model updates
        $profileFields = [
            'birth_place',
            'birth_date',
            'gender',
            'religion_id',
            'address',
            'phone_number',
            'number_kk',
            'number_akta',
            'order_child',
            'count_siblings'
        ];
        $filteredData = array_intersect_key($updateData, array_flip($profileFields));

        if ($role == 'student') {
            $student = $this->student->whereUserId($user->id);
            if ($student) {
                try {
                    $request->validate([
                        'birth_place' => 'sometimes|nullable|string|max:255',
                        'birth_date' => 'sometimes|nullable|date',
                        'gender' => 'sometimes|nullable|string',
                        'religion_id' => 'sometimes|nullable|integer',
                        'address' => 'sometimes|nullable|string',
                        'number_kk' => 'sometimes|nullable|string|max:255',
                        'number_akta' => 'sometimes|nullable|string|max:255',
                        'order_child' => 'sometimes|nullable|integer',
                        'count_siblings' => 'sometimes|nullable|integer',
                    ]);
                } catch (ValidationException $e) {
                    return ResponseHelper::error($e->getMessage(), 422, $e->errors());
                }
                $student->update($filteredData);
            }

        } elseif ($role == 'parent') {
            $parent = Parents::where('user_id', $user->id)->first();
            if ($parent) {
                try {
                    $request->validate([
                        'phone_number' => 'sometimes|nullable|string|max:20',
                        'address' => 'sometimes|nullable|string',
                    ]);
                } catch (ValidationException $e) {
                    return ResponseHelper::error($e->getMessage(), 422, $e->errors());
                }

                // Update User data if name/gender changed
                $userData = [];
                if ($request->has('name'))
                    $userData['name'] = $request->name;
                if ($request->has('gender')) {
                    $g = strtolower($request->gender);
                    if (strpos($g, 'laki') !== false || $g == 'male')
                        $userData['gender'] = 'male';
                    elseif (strpos($g, 'perempuan') !== false || $g == 'female')
                        $userData['gender'] = 'female';
                }
                if (!empty($userData))
                    $user->update($userData);

                $parent->update($request->only(['phone_number', 'address']));
            }
        } else {
            $employee = $this->employee->getByUser($user->id);
            if ($employee) {
                try {
                    $request->validate([
                        'phone_number' => 'sometimes|nullable|string|max:20',
                        'birth_place' => 'sometimes|nullable|string|max:255',
                        'birth_date' => 'sometimes|nullable|date',
                        'gender' => 'sometimes|nullable|string',
                        'religion_id' => 'sometimes|nullable|integer',
                        'address' => 'sometimes|nullable|string',
                    ]);
                } catch (ValidationException $e) {
                    return ResponseHelper::error($e->getMessage(), 422, $e->errors());
                }
                $employee->update($filteredData);
            }
        }

        return ResponseHelper::success(null, 'Profile berhasil diupdate');
    }

    public function changePassword(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return ResponseHelper::error('Password saat ini tidak sesuai', 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return ResponseHelper::success(null, 'Password berhasil diubah');
    }

    public function updatePhoto(User $user, Request $request)
    {
        if ($user->id !== auth()->id()) {
            return ResponseHelper::unauthorized();
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $role = $user->roles->first()->name;
        $fullDomain = request()->root();

        $path = $request->file('photo')->store('profile_photos', 'public');

        if ($role == 'student') {
            $student = $this->student->whereUserId($user->id);
            if ($student) {
                if ($student->image) {
                    Storage::disk('public')->delete($student->image);
                }
                $student->update(['image' => $path]);
            }
            $imageUrl = asset($fullDomain . '/storage/' . $path);

        } elseif ($role == 'parent') {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->update(['image' => $path]);
            $imageUrl = asset($fullDomain . '/storage/' . $path);

        } else {
            $employee = $this->employee->getByUser($user->id);
            if ($employee) {
                if ($employee->image) {
                    Storage::disk('public')->delete($employee->image);
                }
                $employee->update(['image' => $path]);
            }
            $imageUrl = asset($fullDomain . '/storage/' . $path);
        }

        return ResponseHelper::success(['image_url' => $imageUrl], 'Foto profile berhasil diupdate');
    }
}
