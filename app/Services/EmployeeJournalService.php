<?php

namespace App\Services;

use App\Contracts\Interfaces\EmployeeInterface;
use App\Enums\StatusEnum;
use App\Http\Requests\StoreEmployeeJournalRequest;
use App\Http\Requests\UpdateEmployeeJournalRequest;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeJournalService
{
    private EmployeeInterface $employee;
    private \App\Contracts\Interfaces\EmployeeJournalInterface $employeeJournal;

    public function __construct(EmployeeInterface $employee, \App\Contracts\Interfaces\EmployeeJournalInterface $employeeJournal)
    {
        $this->employee = $employee;
        $this->employeeJournal = $employeeJournal;
    }

    public function getHistory(User $user, int $days = 30): \Illuminate\Support\Collection
    {
        $existingJournals = $this->employeeJournal->getEmployee($user->id, 'get');

        $history = collect([]);
        $now = \Carbon\Carbon::now();

        // Temukan batas bawah tanggal (tanggal employee masuk/dibuat)
        $employee = $this->employee->getByUser($user->id);

        // Gunakan startOfDay agar pembandingannya konsisten (jam 00:00)
        $floorDate = $employee ? $employee->created_at->copy()->startOfDay() : $now->copy()->subDays($days)->startOfDay();

        // Jika ada jurnal yang lebih tua dari floorDate (misal data lama di database), tetap ijinkan floorDate mundur
        $earliestJournal = $existingJournals->isEmpty() ? null : \Carbon\Carbon::parse($existingJournals->min('created_at'))->copy()->startOfDay();
        if ($earliestJournal && $earliestJournal->isBefore($floorDate)) {
            $floorDate = $earliestJournal;
        }

        for ($i = 0; $i < $days; $i++) {
            $date = $now->copy()->subDays($i);

            // Jika tanggal pengecekan sudah lebih lama dari floorDate, stop generate unfilled
            if ($date->startOfDay()->isBefore($floorDate)) {
                // Kecuali jika ada jurnal nyata di tanggal tsb
                $dateStr = $date->format('Y-m-d');
                $journal = $existingJournals->first(function ($item) use ($dateStr) {
                    return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') === $dateStr;
                });
                if ($journal) {
                    $history->push($journal);
                }
                continue;
            }

            // Skip Saturdays and Sundays
            if ($date->isSaturday() || $date->isSunday())
                continue;

            $dateStr = $date->format('Y-m-d');

            // Find in existing
            $journal = $existingJournals->first(function ($item) use ($dateStr) {
                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') === $dateStr;
            });

            if ($journal) {
                $history->push($journal);
            } else {
                // Create transient instance
                $dummyInstance = new \App\Models\EmployeeJournal();
                $dummyInstance->forceFill([
                    'created_at' => $date,
                    'title' => null,
                    'description' => null,
                    'status' => StatusEnum::NOT_COMPLETED,
                ]);
                $history->push($dummyInstance);
            }
        }

        return $history;
    }

    public function store(StoreEmployeeJournalRequest $request): array|bool
    {
        $data = $request->validated();
        $user = auth()->user();
        $employee = $this->employee->getByUser($user->id);

        return [
            'employee_id' => $employee->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => StatusEnum::COMPLETED->value,
        ];
    }

    public function store_api(Request $request, User $user): array|bool
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $employee = $this->employee->getByUser($user->id);

        return [
            'employee_id' => $employee->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => StatusEnum::COMPLETED->value,
        ];
    }

    public function update(UpdateEmployeeJournalRequest $request): array|bool
    {
        $data = $request->validated();
        $user = auth()->user();
        $employee = $this->employee->getByUser($user->id);

        return [
            'employee_id' => $employee->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => StatusEnum::COMPLETED->value,
        ];
    }
}
