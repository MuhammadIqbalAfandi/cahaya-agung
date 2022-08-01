<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;

class SaleDetailsExport implements
    FromView,
    Responsable,
    WithStyles,
    ShouldAutoSize,
    WithPreCalculateFormulas
{
    use Exportable;

    private $fileName = "sale-report.xlsx";

    public function __construct(private array $data)
    {
    }

    public function view(): View
    {
        ["sales" => $sales] = $this->data;

        return view("Excel.Sales.Export", compact("sales"));
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestDataRow();

        $lastContent = $lastRow - 1;

        $sheet->setCellValue("E$lastRow", "=SUM(E5:E$lastContent)");

        $sheet
            ->getStyle("E")
            ->getNumberFormat()
            ->setFormatCode("#,###");

        return [
            1 => [
                "font" => ["bold" => true, "size" => 12],
                "alignment" => [
                    "vertical" => "center",
                    "horizontal" => "center",
                ],
            ],
            2 => [
                "font" => ["bold" => true, "size" => 12],
                "alignment" => [
                    "vertical" => "center",
                    "horizontal" => "center",
                ],
            ],
            4 => [
                "font" => ["bold" => true],
            ],
            $lastRow => [
                "font" => ["bold" => true, "size" => 12],
            ],
        ];
    }
}
