@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                @if ($antrians->isEmpty())
                    <h1 align="center">Tidak Ada Antrian</h1>
                @endif
            </div>
            @foreach ($antrians as $antrian)
                 <div class="card col-3 mb-3">
                 <img class="card-img-top" src="{{ asset('images/dokter') }}/{{$antrian->foto}}" alt="Card image cap">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><i class="icon-user"></i> {{$antrian->nama_dokter}}</li>
                        <li class="list-group-item"><i class="icon-user-following"></i> {{$antrian->nama_pasien}}</li>
                        <li class="list-group-item"><i class="icon-refresh"></i> {{$antrian->no_antrian}}</li>
                    </ul>
                    <div class="card-footer" align="center">
                        <a href="#" id="mic" id_antrian="{{$antrian->id}}" nama_dokter="{{$antrian->nama_dokter}}" nama_pasien="{{$antrian->nama_pasien}}" no_antrian="{{$antrian->no_antrian}}" nama class="btn btn-primary btn-sm"><i class="icon-microphone"></i></a>
                        <a href="#" id="next" id_antrian="{{$antrian->id}}" class="btn btn-success btn-sm"><i class="icon-control-forward"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://code.responsivevoice.org/responsivevoice.js?key=PlwV6OQC"></script>
<script>
$(document).ready(function(){
    responsiveVoice.setDefaultVoice("Indonesian Male");
    $(document).on('click','#mic',function(e){
        e.preventDefault();
        var id          = $(this).attr('id_antrian');
        var nama_dokter = $(this).attr('nama_dokter');
        var nama_pasien = $(this).attr('nama_pasien');
        var no_antrian  = $(this).attr('no_antrian');
        responsiveVoice.speak(nama_pasien+" Nomor antrian "+no_antrian);
    });
    $(document).on('click','#next',function(e){
        e.preventDefault();
        var id = $(this).attr('id_antrian');
        Swal.fire({
            title: 'Lanjutkan Antrian .?',
            showCancelButton: true,
            confirmButtonText: 'Ya !'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type : 'PUT',
                    url  :  'antrian/'+id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data){
                        // console.log(data);
                        window.location.reload(1);
                    },
                    error:function(data){
                        console.log(data);
                    }
                });
            }
        })
    })
})
</script>
@endsection
