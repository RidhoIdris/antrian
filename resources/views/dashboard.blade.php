@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row portfolio-grid">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                        <figure class="effect-text-in">
                        <img src="{{ asset('images/face7.jpg') }}" alt="image"/>
                        <figcaption>
                            <h1>22</h1>
                            <h4>Dr. Errick Sp.Og</h4>
                            <p>Spesialis Kandungan
                            Estimasi Waktu 1 Jam 2 Menit</p>
                        </figcaption>
                        </figure>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                        <figure class="effect-text-in">
                        <img src="{{ asset('images/face9.jpg') }}" alt="image"/>
                        <figcaption>
                            <h1>22</h1>
                            <h4>Dr. Errick Sp.Og</h4>
                            <p>Spesialis Kandungan
                            Estimasi Waktu 1 Jam 2 Menit</p>
                        </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
