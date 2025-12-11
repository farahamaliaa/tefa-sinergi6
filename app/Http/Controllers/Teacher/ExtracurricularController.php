<?php

namespace App\Http\Controllers\Teacher;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ExtracurricularController extends Controller
{
    private ExtracurricularInterface $extracurricular;

    public function __construct(ExtracurricularInterface $extracurricular)
    {
        $this->extracurricular = $extracurricular;
    }

    public function index(Request $request)
    {
        $employee = auth()->user()->employee;
        
        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->search . '%');
            })
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('teacher.pages.ekstrakulikuler.index', compact('extracurriculars'));
    }
}
