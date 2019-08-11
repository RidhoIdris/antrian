@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <h4 class="card-title d-inline">Master Users</h4>
            <button id="tambah" class="btn btn-success btn-sm float-right mb-3">Tambah User</button>
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
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="150px;" style="text-align:center" >Actions</th>
                </tr>
                </thead>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@include('master_user.modal')
@include('master_user.modal-profile')
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var getData = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('master-user.show','1') }}",
            columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name'},
                        { data: 'email'},
                        { data: 'role'},
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
            $('.modal-header h4').text('Tambah User');
            $('button[type="submit"]').text('Save');
            $('#modal').modal('show');
        });

        $('#form').submit(function(e){
            e.preventDefault();
            NProgress.start();
            var id = $('input[name="id"]').val();
            var name = $('input[name="name"]').val();
            var email = $('input[name="email"]').val();
            var password = $('input[name="password"]').val();
            var password_confirmation = $('input[name="password_confirmation"]').val();
            var role = $('#role :selected').val();
            var button = $('#submit').text();
            var url = '';
            var method = '';
            if(button == 'Save'){
                url = 'master-user';
                method = "post";
            }else{
                url = 'master-user/'+id;
                method = "put";
            }
            $.ajax({
                type : method,
                url  :  url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation,
                    role: role,
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
                        url  :  'master-user/'+id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(){
                            Toast.fire({
                                type: 'success',
                                title: "User Berhasil Di Hapus",
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
            $('.modal-header h4').text('Edit User');
            var id = $(this).attr('data-id');
            $.ajax({
                type : "GET",
                url  :  'master-user/'+id+'/edit',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },success:function(data){

                    $('form :input').val('');
                    $('button[type="submit"]').text('Edit');
                    $('input[name="id"]').val(data.id);
                    $('input[name="name"]').val(data.name);
                    $('#role').val(data.roles[0].name);
                    $('input[name="email"]').val(data.email);
                    $('#modal').modal('show');
                },error:function(data){
                    console.log(data);
                }
            })
        });

        $(document).on('click','#pasien',function(e){
        e.preventDefault();
        @hasrole('admin|perawat')
        var id = $(this).attr('id-user')
        $.ajax({
            type : 'GET',
            url  :  'master-user/getprofilepasien/'+id,
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
                $('#avatar_pasien').attr('src',"{{asset('images/avatar')}}/"+data.pasien.avatar)
                $('#modal').modal('hide');
                $('#modal-profile').modal('show');
            },
            error:function(data){
                console.log(data);
            }
        });
        @endhasrole
    })

    });
</script>
@endsection
