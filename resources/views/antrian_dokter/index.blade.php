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
                        <a href="#" id="list-antrian" id-dokter="{{$antrian->id_dokter}}">
                            <li class="list-group-item"><i class="icon-user"></i> {{$antrian->nama_dokter}}</li>
                        </a>
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
@include('antrian_dokter.modal')
@include('antrian_dokter.modal-profile')
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
    $(document).on('click','#list-antrian',function(e){
        e.preventDefault();
        var id_dokter = $(this).attr('id-dokter');
        $('#tabel').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: "antrian/getpasien/"+id_dokter,
            columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'nama_lengkap'},
                        { data: 'tipe_pembayaran'},
                        { data: 'nama_asuransi'},
                        { data: 'status'},
                    ],
        });
        $('#modal').modal('show');
    })
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

    $(document).on('click','#pasien',function(e){
        e.preventDefault();
        var id = $(this).attr('id-pasien')
        var id_antrian = $(this).attr('id-antrian')
        $.ajax({
            type : 'GET',
            url  :  'antrian/getprofilepasien/'+id+'/'+id_antrian,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                $('#nama_lengkap').val(data.pasien.nama_lengkap)
                $('#no_identitas').val(data.pasien.no_identitas)
                $('#pendidikan').val(data.pasien.pendidikan)
                $('#agama').val(data.pasien.agama)
                $('#no_hp').val(data.pasien.no_hp)
                $('#alamat').text(data.pasien.alamat)
                $('#alamat_pj').text(data.pasien.alamat_pj)
                $('#nama_pj').val(data.pasien.nama_pj)
                $('#no_hp_pj').val(data.pasien.no_hp_pj)
                $('#hubungan').val(data.pasien.hubungan)
                $('#tgl_lahir').val(data.pasien.tanggal_lahir)
                $('#jk').val(data.pasien.jenis_kelamin)
                $('#tipe_pembayaran').val(data.antrian.tipe_pembayaran)
                $('#nama_asuransi').val(data.antrian.nama_asuransi)
                $('#avatar_pasien').attr('src',"{{asset('images/avatar')}}/"+data.pasien.avatar)
                $('#asuransi_pasien').attr('src',"{{asset('images/asuransi-pasien')}}/"+data.antrian.foto_asuransi)
                $('#modal').modal('hide');
                $('#modal-profile').modal('show');
            },
            error:function(data){
                console.log(data);
            }
        });
    })

    $(document).on('click','#close',function(){
        $('#modal-profile').modal('hide')
        $('#modal').modal('show')
    })
})
</script>
@endsection
