@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <h4 class="card-title d-inline">Laporan</h4>

        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <form method="POST" target="_BLANK"  action="{{ route('print.cetak') }}">
            @csrf
            <div class="row">
                <div class="form-group col-6">
                    <label for="from">Tipe Pembayaran</label>
                    <select value="{{old('tipe_pembayaran')}}" class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
                        <option value="">---Semua Tipe Pembayaran---</option>
                        <option value="Umum">Umum</option>
                        <option value="Asuransi">Asuransi</option>
                    </select>
                    @error('tipe_pembayaran')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6 asuransi">
                    <label for="from">Asuransi</label>
                    <select value="{{old('asuransi')}}" class="form-control" name="asuransi" id="asuransi">
                        <option value="">---Semua Asuransi---</option>
                        @foreach ($asuransi as $item)
                            <option value="{{$item->id}}">{{$item->nama_asuransi}}</option>
                        @endforeach
                    </select>
                    @error('asuransi')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="from">Pilih Dokter</label>
                    <select value="{{old('dokter')}}" class="form-control" name="dokter" id="dokter">
                        <option value="">---Semua Dokter---</option>
                        @foreach ($mdokter as $dokter)
                            <option value="{{$dokter->id}}">{{$dokter->nama_dokter}}</option>
                        @endforeach
                    </select>
                    @error('dokter')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="from">Dari Tanggal</label>
                    <input value="{{old('from')}}" type="date" id="from" class="form-control" name="from">
                    @error('from')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="to">Sampai Tanggal</label>
                    <input value="{{old('to')}}" type="date" id="to" class="form-control" name="to">
                    @error('to')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-12">
                    <button id="tambah" class="btn btn-success btn-sm mb-3">Cetak</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.asuransi').hide()
        $('#tipe_pembayaran').change(function(){
            if ($(this).val() == 'Asuransi') {
                $('.asuransi').show()
            }else{
                $('.asuransi').hide()

            }
        })
    })
</script>
@endsection
