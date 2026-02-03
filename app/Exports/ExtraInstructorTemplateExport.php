<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExtraInstructorTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['Ahmad Rifai', 'ahmad@email.com', 'password123', 'Laki-laki', '081234567890', 'Jl. Contoh No. 1', 'Basket'],
            ['Siti Aminah', 'siti@email.com', 'password123', 'Perempuan', '081234567891', 'Jl. Contoh No. 2', 'Pramuka'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pembina',
            'Email',
            'Password',
            'Jenis Kelamin',
            'Nomor HP',
            'Alamat',
            'Ekstrakurikuler',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
