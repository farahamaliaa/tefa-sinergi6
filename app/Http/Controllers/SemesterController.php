<?php

namespace App\Http\Controllers;

// use App\Contracts\Interfaces\SemesterInterface;
// use App\Models\Semester;
// use App\Http\Requests\StoreSemesterRequest;
// use App\Http\Requests\UpdateSemesterRequest;
use App\Services\SemesterService;

class SemesterController extends Controller
{

    private SemesterService $semesterService;

    public function __construct(SemesterService $semesterService) {
        $this->semesterService = $semesterService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentSemester = $this->semesterService->getCurrentSemester();
        return view('school.pages.semesters.index', compact('currentSemester'));
    }

    //(new) current semester
    public function currentSemester()
    {
        $currentSemester = $this->semesterService->getCurrentSemester();
        return response()->json([
            'current_semester' => $currentSemester,
        ]);
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // try {
        //     $semester = $this->semester->store($request->validated());
        //     return response()->json(['semester' => $semester], 200);
        // } catch (\Throwable $th) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
