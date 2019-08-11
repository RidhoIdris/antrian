@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                @empty($dokters)

                <h1 align="center">Maaf Dokter Tidak Tersedia</h1>
                @endempty

                <div class="row portfolio-grid">
                    @foreach ($dokters as $dokter)
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12">
                        <figure class="effect-text-in">
                            <a href="#" id="dokter" jam-mulai="{{$dokter->jam_mulai}}" jam-selesai="{{$dokter->jam_selesai}}" id-jadwal="{{ $dokter->id_jadwal }}" id-dokter="{{ $dokter->id }}" no-antrian="{{$dokter->no_antrian}}">
                                <img src="{{ asset('images/dokter') }}/{{$dokter->foto}}" alt="image"/>
                                <figcaption>
                                    <h1>{{$dokter->no_antrian}}</h1>
                                    <h4>{{$dokter->nama_dokter}}</h4>
                                    {{-- <h4>{{$dokter->jam_mulai}} s/d {{$dokter->jam_selesai}} </h4> --}}
                                    <p>{{'Spesialis : ('.$dokter->nama_spesialis.') Jam Praktek : '. $dokter->jam_mulai.' s/d '.$dokter->jam_selesai}}</p>
                                </figcaption>
                            </figure>
                        </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@include('antrian.modal')
@endsection
@section('script')
<script>
$(document).ready(function(){
    const Toast = Swal.mixin({
            toast: true,
            customClass: {container: 'my-swal'},
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
    });

    $('#form').submit(function(e){
        e.preventDefault();
        NProgress.start();
        var tipe_pembayaran = $('#tipe_pembayaran :selected').val();
        var id_asuransi     = $('#id_asuransi     :selected').val();
        var no_antrian      = $('#no_antrian').val();
        var id_dokter       = $('#id_dokter').val();
        var id_jadwal       = $('#id_jadwal').val();
        var button          = $('#submit').text();
        $.ajax({
            type : 'post',
            url  : 'home',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                tipe_pembayaran: tipe_pembayaran,
                id_jadwal    : id_jadwal,
                id_asuransi    : id_asuransi,
                id_dokter      : id_dokter,
                no_antrian     : no_antrian,
            },
            success:function(data){
                $('#modal').modal('hide');
                console.log(data.request);
                Toast.fire({
                    type  : 'success',
                    title : data.message
                });
                NProgress.done();
                setTimeout(function(){
                    window.location.reload(1);
                }, 1000);
            },
            error:function(data){
                Toast.fire({
                    type: 'error',
                    title: data.responseJSON.errors,
                });
                NProgress.done();
            }
        });
    });


    $(document).on('click','#dokter',function(e){
        e.preventDefault();
        var id_dokter = $(this).attr('id-dokter');
        var no_antrian = parseInt($(this).attr("no-antrian"))+1;
        var id_jadwal = $(this).attr('id-jadwal');
        var jam_mulai = $(this).attr('jam-mulai');
        var jam_selesai = $(this).attr('jam-selesai');
        var jam_sekarang = "{{date('H:i:s')}}";
        if (jam_sekarang<jam_mulai || jam_sekarang>jam_selesai) {
            Toast.fire({
                    type: 'error',
                    title: 'Antrian Belum Dibuka',
                });
        } else {
            $('form :input').val('');
            $('.asuransi').hide();
            $('#modal h4').text('No Antrian Anda Adalah '+no_antrian);
            $('#id_dokter').val(id_dokter);
            $('#no_antrian').val(no_antrian);
            $('#id_jadwal').val(id_jadwal);
            $('#modal').modal('show');
            $('#tipe_pembayaran').change(function(){
                if ($(this).val() == 'Asuransi') {
                    $('.asuransi').show();
                } else {
                    $('.asuransi').hide();
                }
            })
        }
    });
})
</script>
@endsection
