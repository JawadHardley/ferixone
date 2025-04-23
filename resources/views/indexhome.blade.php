@extends('layouts.mainlayout')
@section('content')

<div class="row">
    <div class="col mt-5">
        <div class="container d-flex justify-content-center align-items-center w-30">
            <div class="p-5 bg-light rounded shadow-lg">
                <div class="card d-flex flex-column">
                    <div class="row row-0 flex-fill">
                        <div class="col-md-3">
                            <a href="#">
                                <img src="{{ asset('storage/images/homerun.jpg') }}"
                                    class="w-100 h-100 img-fluid object-cover" alt="Card side image" />
                            </a>
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="#">Welcome to Document Generator</a>
                                </h3>
                                <div class="text-secondary">
                                    Click the button below and access greatness
                                </div>
                                <div class="d-flex align-items-center pt-4 mt-auto">
                                    @php
                                    $imageUrl = asset('storage/images/uchiha.jpg');
                                    @endphp
                                    <span class="avatar"
                                        style="background-image: url('{{ $imageUrl }}')"></span>
                                    <div class="ms-3">
                                        <a href="#" class="text-body">Jawad Charles</a>
                                        <div class="text-secondary">Developer</div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-25">Generate Documents</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection