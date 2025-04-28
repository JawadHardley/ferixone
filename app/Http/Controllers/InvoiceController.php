<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceUpload;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RecordsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvoiceImport;
use Carbon\Carbon;



class InvoiceController extends Controller
{
    public function payform()
    {
        return view('payform');
    }

    public function statementform()
    {
        return view('statementform');
    }

    public function create()
    {
        // $records = Invoice::all();
        // $records = pushtoload::where('sct', 'no')->get();
        $records = Invoice::simplepaginate(10);

        return view('payshow', compact('records'));
        // return view('payshow');
    }

    public function create2()
    {
        // $records = Invoice::all();
        // $records = pushtoload::where('sct', 'no')->get();
        $records = InvoiceUpload::simplepaginate(10);

        return view('statementshow', compact('records'));
        // return view('payshow');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date' => 'required|date',

            'feri_quantity' => 'required|integer',
            'feri_units' => 'required|string',

            'cod_quantities' => 'required|integer',
            'cod_units' => 'required|string',

            'euro_rate' => 'required|numeric',

            'transporter_quantity' => 'required|integer',

            'customer_ref' => 'required|string',
            'customer_po' => 'required|string',
            'customer_trip_no' => 'required|string',
            'application_invoice_no' => 'required|string',
            'certificate_no' => 'required|string',
        ]);

        Invoice::create($validated);

        return redirect()->route('invoices.create')->with('success', 'Invoice saved successfully!');
    }

    public function store2(Request $request)
    {
        $validated = $request->validate([
            // 'import_data' => 'required|mimes:xlsx,xls|max:2048', // Validate as Excel files only
        ]);
        $file = $request->file('import_data');

        // Import Excel data
        $data = Excel::toArray(new InvoiceImport, $file);
        // dd($data);

        // Process each row from the Excel file
        $invoiceData = [];
        foreach ($data[0] as $row) {
            // Ensure the order: [date, Invoice No, Feri/AD No, Cus Trip No, PO, Amount]
            $invoiceData = [
                // 'date' => \Carbon\Carbon::parse($row[1])->format('d/m/Y'),
                'invoice_no' => $row[0],
                'date' => $row[1],
                'feri_ad_no' => $row[2],
                'cus_trip_no' => $row[3],
                'po' => $row[4],
                'amount' => $row[5]
            ];
            InvoiceUpload::create($invoiceData);
        }


        return redirect()->route('invoices.create')->with('success', 'Invoice saveds successfully!');
    }

    public function download(Invoice $invoice)
    {
        $pdf = Pdf::loadView('theinvoice', ['invoice' => $invoice]);
        // dd($invoice->id);
        return $pdf->download("{$invoice->customer_trip_no}.pdf");
    }

    public function download2(InvoiceUpload $InvoiceUpload)
    {
        $invoiceData = InvoiceUpload::all();
        $pdf = Pdf::loadView('thestatement', ['invoiceData' => $invoiceData]);
        // dd($invoice->id);
        return $pdf->download("xss.pdf");
    }

    public function exportexcel(Invoice $invoice)
    {
        return Excel::download(new RecordsExport, 'Invoice List.xlsx');
    }

    public function uploadExcel(Request $request)
    {

        // Validate the uploaded file is an Excel file
        $validated = $request->validate([
            'import_data' => 'required|mimes:xlsx,xls|max:2048', // Validate as Excel files only
        ]);

        if ($validated) {
            // Handle the uploaded file
            $file = $request->file('import_data');

            // Import Excel data
            $data = Excel::toArray(new InvoiceImport, $file);

            // Process each row from the Excel file
            $invoiceData = [];
            foreach ($data[0] as $row) {
                // Ensure the order: [date, Invoice No, Feri/AD No, Cus Trip No, PO, Amount]
                $invoiceData[] = [
                    // 'date' => \Carbon\Carbon::parse($row[1])->format('d/m/Y'),
                    'date' => $row[1],
                    'invoice_no' => $row[0],
                    'feri_ad_no' => $row[2],
                    'cus_trip_no' => $row[3],
                    'po' => $row[4],
                    'amount' => $row[5]
                ];
            }

            // dd($invoiceData);

            // Generate PDF with the imported data
            // $pdf = Pdf::loadView('thestatement', compact('invoiceData'));
            $pdf = Pdf::loadView('thestatement', compact('invoiceData'));
            // $pdf = Pdf::loadHTML('<h1>Hello World</h1>');

            // Download PDF
            return $pdf->download("ALM Statement.pdf");
        }
    }

    public function destroy($id)
    {
        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Delete the invoice
        $invoice->delete();

        // Redirect back with a success message
        return redirect()->route('invoices.create')->with('success', 'Invoice deleted successfully!');
    }
}
