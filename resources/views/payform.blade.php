@extends('layouts.innerlayout')
@section('content')

<!-- Photo -->
@php
$imageUrl = asset('storage/images/load.png');
$imageUrl2 = asset('storage/images/pi.png');
@endphp

<div class="row row-deck row-cards">
    <div class="col">
        <div class="container d-flex justify-content-center align-items-center shadow-lg">
            <form action="{{ route('invoices.store') }}" method="POST" class="w-100 p-5">
                @csrf
                <h1 class="text-muted">Input Invoice Data</h1>

                <div class="row">
                    <!-- <div class="col-4 mb-3">
                        <label class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" name="invoice_number" placeholder="e.g. INV-2025-001" required />
                    </div> -->

                    <div class="col-6 mb-3">
                        <label class="form-label">Invoice Date</label>
                        <input type="date" class="form-control" name="invoice_date" autocomplete="on" required />
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">Euro Rate</label>
                        <input type="number" step="0.0001" min="0" class="form-control" name="euro_rate" placeholder="e.g. 2630.2500" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">FERI Quantity</label>
                        <input type="number" step="1" min="0" class="form-control" name="feri_quantity" placeholder="e.g. 100" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">FERI Units</label>
                        <input type="text" class="form-control" name="feri_units" placeholder="e.g. containers, tons" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">COD Quantities</label>
                        <input type="number" step="1" min="0" class="form-control" name="cod_quantities" placeholder="e.g. 50" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">COD Units</label>
                        <input type="text" class="form-control" name="cod_units" placeholder="e.g. containers, pallets" autocomplete="on" required />
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Transporter Quantity</label>
                        <input type="number" step="1" min="0" class="form-control" name="transporter_quantity" placeholder="e.g. 3" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">Customer Reference</label>
                        <input type="text" class="form-control" name="customer_ref" placeholder="e.g. 11080320 -ALE 708" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">Customer PO</label>
                        <input type="text" class="form-control" name="customer_po" placeholder="Enter Purchase Order Number" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">Customer Trip No</label>
                        <input type="text" class="form-control" name="customer_trip_no" placeholder="Enter Purchase Order Number" autocomplete="on" required />
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label">Application Invoice Number</label>
                        <input type="text" class="form-control" name="application_invoice_no" placeholder="e.g. APP-2025-001" autocomplete="on" required />
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">FERI / COD Certificate Number</label>
                        <input type="text" class="form-control" name="certificate_no" placeholder="e.g. CERT-2025-XYZ" autocomplete="on" required />
                    </div>

                </div>

                <div class="mb-3 text-end">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection