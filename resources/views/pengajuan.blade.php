@extends('adminlte::page')

@section('title', 'Pengajuan 2')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/card.css') }}">
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">
<style>
    @media(max-width:512px) {
        .header-text-home {
            font-size: 24px;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 20px;
        }

        /* .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 10rem;
            height: 10rem;
        }

        .icon {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        } */


    }
</style>

@stop

@section('content')



{{-- <div class="ag-format-container d-none">
    <div class="ag-courses_box">
        <div class="ag-courses_item">
            <a href="{{route('surat.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg circle-red"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background circle-red">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Nomer Surat
                </div>
            </a>
        </div>


        <div class="ag-courses_item">
            <a href="{{route('url.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fas fa-qrcode"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Short Link / QR Code
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuansinglelink.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Single Link
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanzoom.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-video"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Zoom Meeting
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanblastemail.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Blast Email
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanform.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-brands fa-wpforms"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Gooogle Form
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('peminjaman.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-regular fa-handshake"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Peminjaman Alat TIK
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanperbaikan.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Perbaikan Alat TIK
                </div>
            </a>
        </div>


        <div class="ag-courses_item">
            <a href="{{route('ajuandesain.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg circle-green"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background circle-green">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Permohonan Desain
                </div>
            </a>
        </div>

    </div>
</div> --}}


<div class="container-fluid">
    <h2>Pengajuan</h2>
    <div class="m-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-3">
                <a href="{{route('surat.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </h2>
                            <h5>Nomer Surat</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('url.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fas fa-qrcode"></i>
                            </h2>
                            <h5>Short Link / QR Code</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('ajuansinglelink.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-solid fa-link"></i>
                            </h2>
                            <h5>Single Link</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('ajuanzoom.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-solid fa-video"></i>
                            </h2>
                            <h5>Zoom Meeting</h5>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-3">
                <a href="{{route('ajuanblastemail.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fas fa-envelope"></i>
                            </h2>
                            <h5>Blast Email</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('ajuanform.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-brands fa-wpforms"></i>
                            </h2>
                            <h5>Gooogle Form</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('peminjaman.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-regular fa-handshake"></i>
                            </h2>
                            <h5>Peminjaman Alat TIK</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('ajuanperbaikan.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </h2>
                            <h5>Perbaikan Alat TIK</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{route('ajuandesain.index')}}">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2>
                                <i class="fa-solid fa-palette"></i>
                            </h2>
                            <h5>Permohonan Desain</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>


    @stop