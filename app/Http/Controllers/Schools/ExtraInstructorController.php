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

class ExtraInstructorController extends Controller
{
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
            'phone_number' => 'nullable|string|max:20',
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

        $employee = Employee::create([
            'user_id' => $user->id,
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
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'extracurricular_ids' => 'nullable|array',
            'extracurricular_ids.*' => 'exists:extracurriculars,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);

        if ($user->employee) {
            $user->employee->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);

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
