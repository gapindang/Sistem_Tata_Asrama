<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArrayExport implements FromArray, WithHeadings, WithColumnWidths, WithStyles
{
    protected $rows;
    protected $headings;

    public function __construct(array $rows, array $headings = [])
    {
        $this->headings = $headings;
        $this->rows = $rows;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * Auto-width untuk kolom berdasarkan konten
     */
    public function columnWidths(): array
    {
        $widths = [];
        $columnCount = count($this->headings);

        for ($i = 0; $i < $columnCount; $i++) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);

            // Hitung lebar maksimal dari heading dan data
            $maxWidth = strlen($this->headings[$i] ?? '');

            foreach ($this->rows as $row) {
                if (isset($row[$i])) {
                    $length = strlen((string)$row[$i]);
                    if ($length > $maxWidth) {
                        $maxWidth = $length;
                    }
                }
            }

            // Tambah padding dan batasi maksimal
            $widths[$columnLetter] = min(max($maxWidth + 2, 10), 50);
        }

        return $widths;
    }

    /**
     * Style untuk header
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
