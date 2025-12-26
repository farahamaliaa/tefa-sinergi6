<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use App\Models\ExtracurricularJournal;
use Illuminate\Http\Request;

class ExtracurricularJournalController extends Controller
{
    public function show(Request $request)
    {
        $query = ExtracurricularJournal::with([
            'extracurricular.employee.user',
            'schedule',
            'attendances'
        ])->orderBy('date', 'desc');

        if ($request->filled('name')) {
            $query->whereHas('extracurricular', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })->orWhereHas('extracurricular.employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $allJournals = $query->paginate(10);

        return view('school.pages.journals.journal-extracurricular', compact('allJournals'));
    }

    public function export(Request $request)
    {
        $journals = ExtracurricularJournal::with([
            'extracurricular.employee.user',
            'schedule',
            'attendances'
        ])->orderBy('date', 'desc')->get();

        return view('school.pages.journals.export-extracurricular', compact('journals'));
    }

    public function downloadJournal(Request $request)
    {
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan');
    }
}
