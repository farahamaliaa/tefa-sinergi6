<?php

namespace App\Http\Controllers\Schools;

use App\Contracts\Interfaces\EmployeeJournalInterface;
use App\Enums\StatusEnum;
use App\Exports\EmployeeJournalExport;
use App\Http\Controllers\Controller;
use App\Models\EmployeeJournal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExtracurricularJournalController extends Controller
{
    private EmployeeJournalInterface $employeeJournal;

    public function __construct(EmployeeJournalInterface $employeeJournal)
    {
        $this->employeeJournal = $employeeJournal;
    }

    public function show(Request $request)
    {
        $allJournals = $this->employeeJournal->search($request);
        $completedJournals = $this->employeeJournal->getByStatus(StatusEnum::COMPLETED->value, $request);
        $notCompletedJournals = $this->employeeJournal->getByStatus(StatusEnum::NOT_COMPLETED->value, $request);

        return view('school.pages.journals.journal-extracurricular', compact('completedJournals', 'notCompletedJournals', 'allJournals'));
    }

    public function export(Request $request)
    {
        $journals = $this->employeeJournal->export($request);
        return view('school.pages.journals.export-extracurricular', compact('journals'));
    }

    public function downloadJournal(Request $request)
    {
        return Excel::download(new EmployeeJournalExport($this->employeeJournal, $request), 'Jurnal-Pembina-Ekskul.xlsx');
    }
}
