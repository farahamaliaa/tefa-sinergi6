<?php

namespace App\Services;

use App\Models\SchoolYear;
use Illuminate\Support\Facades\Log;

class SchoolYearRolloverService
{
    private SemesterService $semesterService;

    public function __construct(SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    /**
     * Ensure the active school year label is up-to-date.
     * If mismatch found, it renames the active record (Perpetual Model).
     * 
     * @return void
     */
    public function handleRollover(): void
    {
        $expectedLabel = $this->semesterService->getCurrentSchoolYearLabel();
        
        $activeYear = SchoolYear::where('active', true)->first();

        if (!$activeYear) {
            // If no active year, find the last created one or create a new one
            $activeYear = SchoolYear::latest()->first() ?: SchoolYear::create([
                'school_year' => $expectedLabel,
                'active' => true
            ]);
        }

        if ($activeYear->school_year !== $expectedLabel) {
            Log::info("Triggering automatic school year rollover: {$activeYear->school_year} -> {$expectedLabel}");
            $activeYear->update(['school_year' => $expectedLabel]);
        }
    }
}
