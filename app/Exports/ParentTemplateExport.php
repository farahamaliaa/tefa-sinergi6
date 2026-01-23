<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParentTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            ['Budi Santoso', 'budi@email.com', 'password123', 'Laki-laki', '081234567890', 'Ahmad Budi'],
            ['Budi Santoso', '', '', '', '', 'Siti Budi'],
            ['Sari Wulandari', 'sari@email.com', 'password123', 'Perempuan', '081234567891', 'Dina Sari'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Orang Tua',
            'Email',
            'Password',
            'Jenis Kelamin',
            'Nomor HP',
            'Nama Anak',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
