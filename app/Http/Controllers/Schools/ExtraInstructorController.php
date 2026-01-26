<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Extracurricular;
use App\Imports\ExtraInstructorImport;
use App\Exports\ExtraInstructorTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use App\Traits\UploadTrait;
use App\Enums\UploadDiskEnum;

class ExtraInstructorController extends Controller
{
    use UploadTrait;
    public function index(Request $request)
    {
        $pembinas = User::role('extracurricular')
            ->with(['employee', 'employee.extracurriculars'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        $extracurriculars = Extracurricular::all();

        return view('school.pages.extra-instructor.index', compact('pembinas', 'extracurriculars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:13',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'extracurricular_ids' => 'nullable|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
        ]);

        $slug = Str::slug($request->name);
        $count = User::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $user = User::create([
            'name' => $request->name,
            'slug' => $slug,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'extracurricular',
            'gender' => $request->gender,
        ]);

        $user->assignRole('extracurricular');

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $this->upload(UploadDiskEnum::TEACHER->value, $request->file('image'));
        }

        $employee = Employee::create([
            'user_id' => $user->id,
            'image' => $imagePath,
            'nip' => $request->nip ?? '000000000000000000',
            'birth_date' => $request->birth_date ?? now()->subYears(30)->format('Y-m-d'),
            'birth_place' => $request->birth_place ?? '-',
            'nik' => $request->nik ?? '0000000000000000',
            'phone_number' => $request->phone_number ?? '0000000000000',
            'gender' => $request->gender,
            'address' => $request->address ?? '-',
            'status' => 'staff',
            'active' => true,
        ]);

        if ($request->has('extracurricular_ids') && !empty($request->extracurricular_ids)) {
            Extracurricular::whereIn('id', $request->extracurricular_ids)
                ->update(['employee_id' => $employee->id]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan pembina ekstrakurikuler');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:13',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'extracurricular_ids' => 'nullable|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if (!$user->employee) {
            $user->employee()->create([
                'nip' => '000000000000000000',
                'birth_date' => now()->subYears(30)->format('Y-m-d'),
                'birth_place' => '-',
                'nik' => '0000000000000000',
                'phone_number' => $request->phone_number ?? '0000000000000',
                'gender' => $request->gender,
                'address' => $request->address ?? '-',
                'status' => 'staff',
                'active' => true,
                'religion_id' => 1,
            ]);
            $user->refresh();
        }

        if ($user->employee) {
            $dataEmployee = [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
            ];

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if ($user->employee->image) {
                    $this->remove($user->employee->image);
                }
                $dataEmployee['image'] = $this->upload(UploadDiskEnum::TEACHER->value, $request->file('image'));
            }

            $user->employee->update($dataEmployee);

            Extracurricular::where('employee_id', $user->employee->id)
                ->update(['employee_id' => null]);

            if ($request->has('extracurricular_ids') && !empty($request->extracurricular_ids)) {
                Extracurricular::whereIn('id', $request->extracurricular_ids)
                    ->update(['employee_id' => $user->employee->id]);
            }
        }

        return redirect()->back()->with('success', 'Berhasil mengupdate pembina ekstrakurikuler');
    }

    public function destroy(User $user)
    {
        if ($user->employee) {
            if ($user->employee->image) {
                $this->remove($user->employee->image);
            }

            Extracurricular::where('employee_id', $user->employee->id)
                ->update(['employee_id' => null]);
            
            $user->employee->delete();
        }

        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus pembina ekstrakurikuler');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ExtraInstructorImport, $request->file('file'));
            return redirect()->back()->with('success', 'Berhasil mengimport data pembina ekstrakurikuler');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ExtraInstructorTemplateExport, 'template-import-pembina-ekstrakurikuler.xlsx');
    }
}
