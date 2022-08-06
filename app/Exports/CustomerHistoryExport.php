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

class CustomerHistoryExport implements
    FromView,
    Responsable,
    WithStyles,
    ShouldAutoSize,
    WithPreCalculateFormulas
{
    use Exportable;

    private $fileName = "customer-history-report.xlsx";

    public function __construct(private array $data)
    {
    }

    public function view(): View
    {
        ["sales" => $sales] = $this->data;

        return view("Excel.Customers.Export", compact("sales"));
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestDataRow();

        $lastContent = $lastRow - 1;

        $sheet->setCellValue("H$lastRow", "=SUM(H5:H$lastContent)");

        $sheet
            ->getStyle("H")
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
