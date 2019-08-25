<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="RidhoIdris">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('print/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('print/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
       <h2 align="center">Rs. Syafira Pekanbaru</h2>
       <hr>
       <br>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Dokter</th>
                  <th>Nama Pasien</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Antrian</th>
                  <th>Jam</th>
                  <th>Hari</th>
                  <th>Tipe Pembayaran</th>
                  <th>Nama Asuransi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($datas as $key=>$data)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$data->nama_dokter}}</td>
                        <td>{{$data->nama_lengkap}}</td>
                        <td>{{$data->jenis_kelamin}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->jam}}</td>
                        <td>{{$data->hari}}</td>
                        <td>{{$data->tipe_pembayaran}}</td>
                        <td>{{$data->nama_asuransi}}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            <br>
            Pekanbaru. {{ date('d-m-Y') }}
            <br><br><br><br>
            {{ Auth::user()->name }}
          </div>
    </div>
  </div>
</div>


<script src="{{ asset('print/js/jquery.min.js') }}"></script>
<script src="{{ asset('print/js/bootstrap.min.js') }}"></script>
</body>
</html>
