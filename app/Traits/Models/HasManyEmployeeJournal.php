<?php

namespace App\Traits\Models;

use App\Models\EmployeeJournal;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyEmployeeJournal {
    /**
     * Get all of the journals for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeJournals(): HasMany
    {
        return $this->hasMany(EmployeeJournal::class);
    }
}
