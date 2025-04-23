<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function payform()
    {
        return view('payform');
    }

    public function create()
    {
        $records = Invoice::all();
        // $records = pushtoload::where('sct', 'no')->get();
        return view('payshow', compact('records'));
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

    public function download(Invoice $invoice)
    {
        $pdf = Pdf::loadView('theinvoice', ['invoice' => $invoice]);
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
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
