<?php

namespace App\Services;

use App\Contracts\Interfaces\LessonScheduleInterface;
use App\Http\Requests\ImportLessonScheduleRequest;
use App\Models\Classroom;
use Flowgistics\XML\XMLFacade as XML;

class ImportLessonScheduleService
{
    private LessonScheduleInterface $lessonSchedule;

    public function __construct(LessonScheduleInterface $lessonSchedule)
    {
        $this->lessonSchedule = $lessonSchedule;
    }

    public function xml(ImportLessonScheduleRequest $request): void
    {
        // Logic for XML import will go here
    }
}
