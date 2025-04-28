@extends('layouts.innerlayout')
@section('content')

<!-- Photo -->
@php
$imageUrl = asset('storage/images/load.png');
$imageUrl2 = asset('storage/images/pi.png');
@endphp



<div class="row row-deck row-cards">
    <div class="col">
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <!-- here is the body cols -->

                    @if(session('success'))
                    <!-- <div class="col-12"> -->
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <i class="fa fa-warning"></i>
                        </div>
                        {{ session('success') }}
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                    <!-- </div> -->
                    @endif

                    <h1 class="px-3 py-0 my-0">
                        All Invoices
                    </h1>

                    <div class="col-12 p-3">
                        <a href="{{ route('invoices.exportexcel') }}" class="btn btn-success">Export<i class="fa fa-download ps-2"></i></a>
                    </div>
                    <div class="col-12 px-3">
                        <input
                            type="text"
                            class="form-control"
                            id="myInput"
                            onkeyup="mytableFunction()"
                            placeholder="Search .." />
                    </div>

                    <div class="col-12 p-5 rounded">

                        <table class="table" id="myTable">
                            <thead class="bg">
                                <tr class="header">
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Customer Trip Number</th>
                                    <th>Customer PO</th>
                                    <th>App. Invoice No</th>
                                    <th>Total (€)</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)

                                @php
                                // Fetching the required values from $record (not $invoice)
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
                                $grandTotal = ($transporterAmount + ($upTotal * $euroRate)) - 5;

                                // Formatting the date
                                $formattedDate = \Carbon\Carbon::parse($record->invoice_date)->format('d - F - Y');
                                @endphp
                                <tr class="border">
                                    <td class="border p-3">PRES-2025-{{ $record->id }}</td>
                                    <td class="border p-3">
                                        {{ \Carbon\Carbon::parse($record->invoice_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="border p-3">{{ $record->customer_trip_no }}</td>
                                    <td class="border p-3">{{ $record->customer_po }}</td>
                                    <td class="border p-3">{{ $record->application_invoice_no }}</td>
                                    <td class="border p-3">
                                        <!-- € {{ $grandTotal }} -->
                                        $ {{ number_format($grandTotal, 2, '.', ',') }}
                                    </td>
                                    <td class="border p-3 text-center">
                                        <span class="badge bg-success me-1"></span> Complete
                                    </td>
                                    <td class="border p-3 text-center">
                                        <a class="btn btn-light dropdown-toggle w-100" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" target="_blank" href="{{ route('invoices.download', $record->id) }}">
                                                    <i class="fa fa-download text-primary me-2"></i> Download
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#m{{ $record->id }}" class="dropdown-item">
                                                    <i class="fa fa-trash me-2 text-danger"></i> Delete
                                                </button>
                                                <!-- Delete Button -->
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <form action="{{ route('invoices.destroy', $record->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <!-- Modal -->
                                    <!-- <div class="modal fade" id="m{{ $record->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">---------------------------
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        <i class="fa fa-warning text-warning me-2"></i> Caution
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete invoice PRES-2025-{{ $record->id }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="fa fa-trash text-danger me-2"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="modal" id="m{{ $record->id }}" tabindex="-1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="modal-status bg-danger"></div>
                                                <div class="modal-body text-center py-4">
                                                    <i class="mb-2 fs-1 text-danger fa fa-warning" width="24" height="24"></i>
                                                    <h3>Are you sure?</h3>
                                                    <div class="text-secondary">
                                                        Are you sure you want to delete invoice PRES-2025-{{ $record->id }}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="w-100">
                                                        <div class="row">
                                                            <div class="col">
                                                                <a href="#" class="btn w-100" data-bs-dismiss="modal"> Cancel </a>
                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                                    <i class="fa fa-trash me-2"></i> Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal end -->

                                </form>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="col-12 m-0">
                        <!-- $records->links() -->
                    </div>
                    <!-- here is the body cols end -->
                </div>
            </div>
        </div>

    </div>
</div>



@endsection