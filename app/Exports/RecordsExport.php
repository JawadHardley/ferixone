<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;

class RecordsExport implements FromCollection
{

    // // You can pass the $grandtotal value to this class when invoking the export
    // protected $grandTotal;

    // public function __construct($grandTotal)
    // {
    //     $this->grandTotal = $grandTotal;
    // }


    public function collection()
    {
        return Invoice::all()->map(function ($record) {
            // Calculate necessary fields dynamically
            $feriQty = $record->feri_quantity ?? 0;
            $feriUnits = $record->feri_units ?? 0;
            $codQty = $record->cod_quantities ?? 0;
            $codUnits = $record->cod_units ?? 0;
            $euroRate = $record->euro_rate ?? 1; // Default euro rate if not set
            $transporterQty = $record->transporter_quantity ?? 0;

            // Calculating the amounts
            $feriAmount = $feriQty * $feriUnits; // Feri amount: qty * units
            $codAmount = $codQty * $codUnits; // COD amount: qty * units

            // Calculating the UP Total: feri amount + cod amount
            $upTotal = $feriAmount + $codAmount;

            // Calculating the transporter amount: transporter qty * 0.018
            $transporterAmount = $transporterQty * 0.018;

            // Calculating the grand total: transporter amount + (up total * euro rate)
            // $grandTotal = ($transporterAmount + ($upTotal * $euroRate)) - 5;
            $grandTotal = number_format(($transporterAmount + ($upTotal * $euroRate)) - 5, 2, '.', '');


            // Prepare the export data for each record
            return [
                'invoice_number' => 'PRES-2025-' . $record->id, // Format the invoice number
                'invoice_date' => \Carbon\Carbon::parse($record->invoice_date)->format('d/m/Y'),
                'customer_trip_number' => $record->customer_trip_no,
                'customer_po' => $record->customer_po,
                'app_invoice_no' => $record->application_invoice_no,
                'total' => $grandTotal, // Pass the calculated grand total
                'status' => 'completed' // Hardcoded as 'completed'
            ];
        });
    }

    // Define your headings (similar to your table's header)
    public function headings(): array
    {
        return [
            'Invoice Number',
            'Invoice Date',
            'Customer Trip Number',
            'Customer PO',
            'App. Invoice No',
            'Total ($)',
            'Status'
        ];
    }

    // Styling the Excel sheet
    // public function styles($sheet)
    // {
    //     return [
    //         // Custom styles for header
    //         1 => [
    //             'font' => ['bold' => true, 'size' => 14],
    //             'alignment' => ['horizontal' => 'center'],
    //             'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9EAD3']],
    //         ],
    //         // Styling for data rows
    //         'A2:G' . $sheet->getHighestRow() => [
    //             'alignment' => ['horizontal' => 'center'],
    //             'font' => ['size' => 12]
    //         ]
    //     ];
    // }

    // // Optional: Format columns (like numbers or dates)
    // public function columnFormats(): array
    // {
    //     return [
    //         'F' => '#,##0.00', // For 'Total (€)' column, format as currency
    //         'B' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDD2, // For 'Invoice Date'
    //     ];
    // }

    // Optional: Title for the Excel Sheet
    public function title(): string
    {
        return 'Invoice Records';
    }
}
