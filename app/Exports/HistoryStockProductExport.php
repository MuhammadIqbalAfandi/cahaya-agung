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

class HistoryStockProductExport implements
    FromView,
    Responsable,
    WithStyles,
    ShouldAutoSize,
    WithPreCalculateFormulas
{
    use Exportable;

    private $fileName = "history-stock-product.xlsx";

    public function __construct(private array $data)
    {
    }

    public function view(): View
    {
        ["historyStockProducts" => $historyStockProducts] = $this->data;

        return view(
            "Excel.StockProducts.Export",
            compact("historyStockProducts")
        );
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestDataRow();

        $lastContent = $lastRow - 1;

        $sheet->setCellValue("G$lastRow", "=SUM(G5:G$lastContent)");

        $sheet
            ->getStyle("G")
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
