<?php

namespace App\Http\Controllers\Extracurricular;

use App\Contracts\Interfaces\ExtracurricularInterface;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;

class DashboardExtracurricularController extends Controller
{
    private ExtracurricularInterface $extracurricular;

    public function __construct(ExtracurricularInterface $extracurricular)
    {
        $this->extracurricular = $extracurricular;
    }


    public function index()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            $extracurriculars = collect([]);
            return view('extracurricular.pages.dashboard.index', compact('extracurriculars'))
                ->with('error', 'Akun Anda belum terhubung dengan data pegawai. Silakan hubungi administrator.');
        }
        
        $extracurriculars = Extracurricular::where('employee_id', $employee->id)
            ->with('extracurricularStudents')
            ->latest()
            ->get();

        return view('extracurricular.pages.dashboard.index', compact('extracurriculars'));
    }
}
