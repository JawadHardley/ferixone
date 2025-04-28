@extends('layouts.innerlayout')
@section('content')


<div class="row row-deck row-cards">
    <div class="col">
        <div class="container d-flex justify-content-center align-items-center shadow-lg">
            <form action="{{ route('invoices.store2') }}" method="POST" enctype="multipart/form-data" class="w-100 p-5">
                @csrf
                <h1 class="text-muted">Import Statement Datas</h1>

                <div class="row">
                    <!-- <div class="col-4 mb-3">
                        <label class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" name="invoice_number" placeholder="e.g. INV-2025-001" required />
                    </div> -->

                    <div class="col-12 mb-3">
                        <label class="form-label">Import Excel File</label>
                        <input type="file" class="form-control" name="import_data" accept=".xlsx,.xls" required />
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