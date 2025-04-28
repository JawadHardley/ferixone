@extends('layouts.innerlayout')
@section('content')

<!-- Photo -->
@php
$imageUrl = asset('storage/images/load.png');
$imageUrl2 = asset('storage/images/pi.png');
@endphp

<div class="row row-deck row-cards">

    <div class="col-sm-6 col-lg-3">
        <a href="{{ route('invoices.payform') }}" class="card card-link">
            <div class="card shadow">
                <div
                    class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url('{{ $imageUrl }}')"></div>
                <div class="card-body">
                    <h3 class="card-title">Load Invoice Data</h3>
                    <p class="text-secondary">
                        Input data that you will use to generate a document with
                    </p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="{{ route('invoices.payform') }}" class="card card-link">
            <div class="card shadow">
                <div
                    class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url('{{ $imageUrl }}')"></div>
                <div class="card-body">
                    <h3 class="card-title">Load Statement Data</h3>
                    <p class="text-secondary">
                        Input data that you will use to generate a document with
                    </p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="{{ route('invoices.create') }}" class="card card-link">
            <div class="card shadow">
                <!-- Photo -->
                <div
                    class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url('{{ $imageUrl2 }}')"></div>
                <div class="card-body">

                    <h3 class="card-title">View List</h3>
                    <p class="text-secondary">
                        View the list of documents you already have in the system
                    </p>
                </div>
            </div>
        </a>
    </div>
</div>


@endsection