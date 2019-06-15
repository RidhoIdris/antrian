@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    @if (session('success'))
        <div align="center" class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session('success')}}</strong>
        </div>
    @endif
    @if (session('danger'))
        <div align="center" class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session('danger')}}</strong>
        </div>
    @endif
    <div class="row user-profile">
      <div class="col-lg-12 side-right stretch-card">
          <div class="card">
          <div class="card-body">
            <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
              <h4 class="card-title mb-0">My Profile</h4>
              <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Avatar</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security">Change Password</a>
                </li>
              </ul>
            </div>
            <div class="wrapper">
              <hr>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                    <form action="{{ route('profile.info',\Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                      <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Change Full Name" value="{{old('nama_lengkap',\Auth::user()->load('pasien')->pasien->nama_lengkap)}}">
                        @error('nama_lengkap')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="nama_panggilan">Nama Panggilan</label>
                    <input type="text" class="form-control" name="nama_panggilan" placeholder="Change Full Name" value="{{old('nama_panggilan',\Auth::user()->load('pasien')->pasien->nama_panggilan)}}">
                        @error('nama_panggilan')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Change Full Name" value="{{old('email',\Auth::user()->email)}}">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="no_hp">No Hp</label>
                    <input type="text" class="form-control" name="no_hp" placeholder="Change Full Name" value="{{old('no_hp',\Auth::user()->load('pasien')->pasien->no_hp)}}">
                        @error('no_hp')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                      <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="{{old('tanggal_lahir',\Auth::user()->load('pasien')->pasien->tanggal_lahir)}}">
                         @error('tanggal_lahir')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select name="agama" id="agama" class="form-control">
                            <option value="">-- Agama --</option>
                            <option value="Islam" {{old('agama',\Auth::user()->load('pasien')->pasien->agama)=="Islam"?"selected":""}} >Islam</option>
                            <option value="Hindu" {{old('agama',\Auth::user()->load('pasien')->pasien->agama)=="Hindu"?"selected":""}} >Hindu</option>
                            <option value="Budha" {{old('agama',\Auth::user()->load('pasien')->pasien->agama)=="Budha"?"selected":""}} >Budha</option>
                            <option value="Kristen Protestan" {{old('agama',\Auth::user()->load('pasien')->pasien->agama)=="Kristen Protestan"?"selected":""}} >Kristen Protestan</option>
                            <option value="Kristen Katholik" {{old('agama',\Auth::user()->load('pasien')->pasien->agama)=="Kristen Katholik"?"selected":""}} >Kristen Katholik</option>

                        </select>
                        @error('agama')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="">-- Jenis Kelamin --</option>
                            <option value="Laki-Laki" {{old('jenis_kelamin',\Auth::user()->load('pasien')->pasien->jenis_kelamin)=="Laki-Laki"?"selected":""}} >Laki-Laki</option>
                            <option value="Perempuan" {{old('jenis_kelamin',\Auth::user()->load('pasien')->pasien->jenis_kelamin)=="Perempuan"?"selected":""}} >Perempuan</option>

                        </select>
                        @error('jenis_kelamin')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                      <label for="alamat">Alamat</label>
                      <textarea name="alamat" id="alamat" rows="6" class="form-control" placeholder="Change Alamat">{{old('alamat',\Auth::user()->load('pasien')->pasien->alamat)}}</textarea>
                        @error('alamat')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group mt-5">
                      <button type="submit" class="btn btn-success mr-2" id="update">Update</button>
                      <button class="btn btn-outline-danger">Cancel</button>
                    </div>
                  </form>
                </div>
                <!-- tab content ends -->
                <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                  <div class="wrapper mb-5 mt-4">
                    <span class="badge badge-warning text-white">Note : </span>
                    <p class="d-inline ml-3 text-muted">Image size is limited to not greater than 1MB .</p>
                  </div>
                <form action="{{ route('profile.avatar',\Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="file" name="image" class="form-control"/>
                    @error('image')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group mt-5">
                      <button type="submit" class="btn btn-success mr-2">Update</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                <form action="{{ route('profile.password',\Auth::user()->load('pasien')->pasien->id_user) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                      <label for="change-password">Change password</label>
                      <input type="password" class="form-control" name="oldpassword" id="change-password" placeholder="Masukan Password Lama">
                      @error('oldpassword')
                      <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="newpassword" id="new-password" placeholder="Masukan Password Baru">
                      @error('newpassword')
                      <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="newpassword_confirmation" id="new-password" placeholder="Ulangi Masukan Password Baru">
                    </div>
                    <div class="form-group mt-5">
                      <button type="submit" class="btn btn-success mr-2">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('script')
    <script>
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert-success").slideUp(500);
    });
    </script>
@endsection
