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

                    <div class="col-12 p-3">
                        <input
                            type="text"
                            class="form-control"
                            id="myInput"
                            onkeyup="mytableFunction()"
                            placeholder="Search .." />
                    </div>

                    <div class="col-12 bg-gray-100 p-5 rounded shadow-lg">
                        <!-- <table class="table table-striped" id="myTable">
                            <thead class="bg">
                                <tr class="header">
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Amount - $</th>
                                    <th>Desc</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                <tr class="border">
                                    <td class="border p-3">{{ $record->invoice_number }}</td>
                                    <td class="border p-3">{{ $record->invoice_date }}</td>
                                    <td class="border p-3">{{ $record->amount }}</td>
                                    <td class="border p-3">{{ $record->description }}</td>
                                    <td class="border p-3 text-center">
                                        <span class="badge bg-warning me-1"></span> Pending
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
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa fa-trash me-2 text-danger"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table> -->

                        <table class="table table-striped" id="myTable">
                            <thead class="bg">
                                <tr class="header">
                                    <th>Invoice Number</th>
                                    <th>Invoice Date</th>
                                    <th>Customer Ref</th>
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
                                    <td class="border p-3">{{ $record->invoice_date }}</td>
                                    <td class="border p-3">{{ $record->customer_ref }}</td>
                                    <td class="border p-3">{{ $record->application_invoice_no }}</td>
                                    <td class="border p-3">


                                        €{{ $grandTotal }}
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
                                                <!-- Delete Button -->
                                                <form action="{{ route('invoices.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fa fa-trash me-2 text-danger"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <!-- here is the body cols end -->
                </div>
            </div>
        </div>

    </div>
</div>



@endsection