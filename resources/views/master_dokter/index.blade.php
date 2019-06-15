@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <h4 class="card-title d-inline">Master Dokter</h4>
            <button id="tambah" class="btn btn-success btn-sm float-right mb-3">Tambah Dokter</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <div class="row">
            <div class="col-12">
            <table id="table" class="table table-bordered"  width="100%">
                <thead>
                <tr>
                    <th width="15px;">#</th>
                    <th>Nama Dokter</th>
                    <th>Spesialis</th>
                    <th>Foto</th>
                    <th width="150px;" style="text-align:center" >Actions</th>
                </tr>
                </thead>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@include('master_dokter.modal')
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var getData = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master-dokter.show','1') }}",
            columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'nama_dokter'},
                        { data: 'spesialis'},
                        { data: 'foto', name: 'foto', orderable:false, searchable:false },
                        { data: 'action', name: 'action', orderable:false, searchable:false },
                    ],
        });
        const Toast = Swal.mixin({
            toast: true,
            customClass: {container: 'my-swal'},
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        $('#tambah').click(function(){
            $('form :input').val('');
            $('.modal-header h4').text('Tambah Dokter');
            $('button[type="submit"]').text('Save');
            $('#modal').modal('show');
        });

        $('#form').submit(function(e){
            e.preventDefault();
            NProgress.start();
            var id = $('input[name="id"]').val();
            var nama_dokter = $('input[name="nama_dokter"]').val();
            var id_spesialis = $('#id_spesialis :selected').val();
            var button = $('#submit').text();
            var url = '';
            var method = '';
            if(button == 'Save'){
                url = 'master-dokter';
                method = "post";
            }else{
                url = 'master-dokter/'+id;
                method = "put";
            }
            $.ajax({
                type : method,
                processData: false,
                contentType: false,
                cache: false,
                url  :  url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : new FormData(this),
                success:function(data){
                    $('#modal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: data.message
                    });
                    getData.ajax.reload();
                    NProgress.done();
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

        $(document).on('click','#hapus',function(e){
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    NProgress.start();
                    $.ajax({
                        type : "DELETE",
                        url  :  'master-dokter/'+id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(){
                            Toast.fire({
                                type: 'success',
                                title: "Dokter Berhasil Di Hapus",
                            });
                            getData.ajax.reload();
                            NProgress.done();
                        },error:function(data){
                            console.log(data);
                            NProgress.done();
                        }
                    })
                }
            })
        });

        $(document).on('click','#edit',function(){
            $('.modal-header h4').text('Edit Dokter');
            var id = $(this).attr('data-id');
            $.ajax({
                type : "GET",
                url  :  'master-dokter/'+id+'/edit',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },success:function(data){
                    $('form :input').val('');
                    $('button[type="submit"]').text('Edit');
                    $('input[name="id"]').val(data.id);
                    $('input[name="nama_dokter"]').val(data.nama_dokter);
                    $('#id_spesialis').val(data.id_spesialis);
                    $('#modal').modal('show');
                },error:function(data){
                    console.log(data);
                }
            })
        });

    });
</script>
@endsection
