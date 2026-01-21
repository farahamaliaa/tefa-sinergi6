<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ExtraInstructorController extends Controller
{
    /**
     * Display a listing of pembina extracurricular.
     */
    public function index(Request $request)
    {
        $pembinas = User::role('extracurricular')
            ->with(['employee', 'employee.extracurriculars'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('school.pages.extra-instructor.index', compact('pembinas'));
    }
}
