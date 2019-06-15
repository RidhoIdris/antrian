@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <h4 class="card-title d-inline">Master Jadwal Dokter</h4>
            <button id="tambah" class="btn btn-success btn-sm float-right mb-3">Tambah Jadwal</button>
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
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th width="150px;" style="text-align:center" >Actions</th>
                </tr>
                </thead>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@include('master_jadwal_dokter.modal')
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var getData = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master-jadwal-dokter.show','1') }}",
            columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'dokter'},
                        { data: 'hari'},
                        { data: 'jam_mulai'},
                        { data: 'jam_selesai'},
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
            $('.modal-header h4').text('Tambah Jadwal Dokter');
            $('button[type="submit"]').text('Save');
            $('#modal').modal('show');
            $('#jam_mulai, #jam_selesai').datetimepicker({
                format: 'HH:mm',
                pickDate: false,
                pickSeconds: false,
                pick12HourFormat: false
            });
        });

        $('#form').submit(function(e){
            e.preventDefault();
            NProgress.start();
            var id = $('input[name="id"]').val();
            var hari = $('#hari :selected').val();
            var jam_mulai = $('input[name="jam_mulai"]').val();
            var jam_selesai = $('input[name="jam_selesai"]').val();
            var id_dokter = $('#id_dokter :selected').val();
            var button = $('#submit').text();
            var url = '';
            var method = '';
            if(button == 'Save'){
                url = 'master-jadwal-dokter';
                method = "post";
            }else{
                url = 'master-jadwal-dokter/'+id;
                method = "put";
            }
            $.ajax({
                type : method,
                url  :  url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    id_dokter: id_dokter,
                    hari: hari,
                    jam_mulai: jam_mulai,
                    jam_selesai: jam_selesai,
                },
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
                        url  :  'master-jadwal-dokter/'+id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(){
                            Toast.fire({
                                type: 'success',
                                title: "Jadwal Berhasil Di Hapus",
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
            $('.modal-header h4').text('Edit Jadwal Dokter');
            var id = $(this).attr('data-id');
            $.ajax({
                type : "GET",
                url  :  'master-jadwal-dokter/'+id+'/edit',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },success:function(data){
                    $('form :input').val('');
                    $('button[type="submit"]').text('Edit');
                    $('input[name="id"]').val(data.id);
                    $('#hari').val(data.hari);
                    $('input[name="jam_mulai"]').val(data.jam_mulai);
                    $('input[name="jam_selesai"]').val(data.jam_selesai);
                    $('#id_dokter').val(data.id_dokter);
                    $('#modal').modal('show');
                },error:function(data){
                    console.log(data);
                }
            })
        });

    });
</script>
@endsection
