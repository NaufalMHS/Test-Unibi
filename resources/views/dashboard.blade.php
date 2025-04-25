@extends('admin.layout.main')

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat datang 🎉</h5>
                            <p class="mb-4">
                                Kamu berada di 
                                <strong id="city" style="font-size: 20px"></strong> 
                                dengan cuaca hari ini 
                                <img src="" id="weather" class="tooltip-weather" alt="Ikon Cuaca.">
                                , suhu sekitar yaitu 
                                <span style="font-size: 20px" id="temp" class="tooltip-temp"></span>
                                dan kelembapan sekitar 
                                <span id="humidity" style="font-size: 20px"></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('admin/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection