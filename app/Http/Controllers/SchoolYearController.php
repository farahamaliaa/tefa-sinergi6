<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ModelHasRfidInterface;
use App\Contracts\Interfaces\SchoolYearInterface;
use App\Contracts\Interfaces\SemesterInterface;
use App\Http\Requests\StoreSchoolYearRequest;
use App\Http\Requests\UpdateSchoolYearRequest;
use App\Services\SchoolYearService;
use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Services\SemesterService;

class SchoolYearController extends Controller
{
    private SchoolYearInterface $schoolYear;
    private SchoolYearService $service;
    private ModelHasRfidInterface $rfid;
    private SemesterInterface $semester;
    private SemesterService $semesterService;

    public function __construct(SchoolYearInterface $schoolYear, SchoolYearService $service, ModelHasRfidInterface $rfid, SemesterInterface $semester, SemesterService $semesterService)
    {
        $this->schoolYear = $schoolYear;
        $this->service = $service;
        $this->rfid = $rfid;
        $this->semesterService = $semesterService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schoolYears = $this->schoolYear->search($request);
        $currentSemester = $this->semesterService->getCurrentSemester();
        return view('school.pages.school-year.index', compact('schoolYears', 'currentSemester'));
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
    public function store(StoreSchoolYearRequest $request)
    {
        try {
            $this->schoolYear->setNonactive();
            $this->schoolYear->store(['school_year' => $request->school_year]);
            return redirect()->back()->with('success', 'Berhasil menambahkan tahun ajaran');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolYearRequest $request, SchoolYear $schoolYear)
    {
        try {
            $this->schoolYear->update($schoolYear->id, ['school_year' => $request->school_year]);
            return redirect()->back()->with('success', 'Berhasil memperbarui tahun ajaran');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolYear $schoolYear)
    {
        try {
            if($schoolYear->active == true) return redirect()->back()->with('warning','Tidak dapat menghapus tahun ajaran aktif');

            $this->schoolYear->delete($schoolYear->id);
            $this->schoolYear->setActive(['active' => 1]);
            return redirect()->back()->with('success', 'Berhasil menghapus tahun ajaran');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan'.$th->getMessage());
        }
    }


    public function setActive(SchoolYear $schoolYear)
    {
        try {
            $oldActiveYear = SchoolYear::where('active', true)->first();

            $this->schoolYear->setNonactive();
            $this->schoolYear->update($schoolYear->id, ['active' => 1]);

            if ($oldActiveYear && $oldActiveYear->id !== $schoolYear->id) {
                $oldClassrooms = \App\Models\Classroom::where('school_year_id', $oldActiveYear->id)->get();

                foreach ($oldClassrooms as $oldClassroom) {
                    $exists = \App\Models\Classroom::where('school_year_id', $schoolYear->id)
                        ->where('name', $oldClassroom->name)
                        ->exists();

                    if (!$exists) {
                        $newClassroom = $oldClassroom->replicate();
                        $newClassroom->id = \Faker\Provider\Uuid::uuid();
                        $newClassroom->school_year_id = $schoolYear->id;
                        $newClassroom->save();

                        $oldStudents = \App\Models\ClassroomStudent::where('classroom_id', $oldClassroom->id)->get();
                        foreach ($oldStudents as $oldStudent) {
                            \App\Models\ClassroomStudent::create([
                                'student_id' => $oldStudent->student_id,
                                'classroom_id' => $newClassroom->id,
                            ]);
                        }

                        $oldSchedules = \App\Models\LessonSchedule::where('classroom_id', $oldClassroom->id)
                            ->where('school_year_id', $oldActiveYear->id)
                            ->get();

                        foreach ($oldSchedules as $oldSchedule) {
                            $newSchedule = $oldSchedule->replicate();
                            $newSchedule->classroom_id = $newClassroom->id;
                            $newSchedule->school_year_id = $schoolYear->id;
                            $newSchedule->save();
                        }
                    }
                }
            }

            return back()->with('success', 'Berhasil mengaktifkan tahun ajaran dan memigrasi data kelas');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
