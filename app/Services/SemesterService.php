<?php

    namespace App\Services;

    use App\Enums\SemesterEnum;
    use App\Models\Semester;

    class SemesterService
    {
        public function __construct()
        {

        }

        //Hitung semester berdasarkan bulan (new feature)
        public function getCurrentSemester(): string
        {
            $month = now()->month;
            return ($month >= 7 && $month <= 12)
                ? SemesterEnum::GANJIL->value
                : SemesterEnum::GENAP->value;
        }

        public function store(array $data)
        {
            return Semester::create($data);
        }

        public function update($semester, array $data)
        {
            return $semester->update($data);
        }

        public function delete($semester)
        {
            return $semester->delete();
        }
    }
