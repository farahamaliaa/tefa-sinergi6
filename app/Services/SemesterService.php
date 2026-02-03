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

        /**
         * Calculate School Year Label based on date
         * July (7) starts a new year cycle.
         * 
         * @param mixed $date
         * @return string (e.g. 2024/2025)
         */
        public function getSchoolYearLabel($date): string
        {
            $carbon = \Carbon\Carbon::parse($date);
            $year = $carbon->year;
            $month = $carbon->month;

            if ($month >= 7) {
                return $year . '/' . ($year + 1);
            } else {
                return ($year - 1) . '/' . $year;
            }
        }

        /**
         * Get the expected label for the current date
         */
        public function getCurrentSchoolYearLabel(): string
        {
            return $this->getSchoolYearLabel(now());
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
