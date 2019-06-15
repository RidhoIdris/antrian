@extends('layouts.master_auth')
@section('content')
<form class="login100-form" method="post" action="{{ route('register.store') }}">
    @csrf
    <span class="login100-form-title p-b-49">
        Register
    </span>
    <div class="wrap-input100 m-b-23" >
        <span class="label-input100">Nama Lengkap</span>
        <input class="input100"  value="{{ old('nama_lengkap') }}"type="text" name="nama_lengkap" placeholder="Type your full name">
        <span class="focus-input100" data-symbol="&#xf206;"></span>
        @error('nama_lengkap')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="wrap-input100 m-b-23" >
        <span class="label-input100">Nama Panggilan</span>
        <input class="input100"  value="{{ old('nama_panggilan') }}"type="text" name="nama_panggilan" placeholder="Type your nick name">
        <span class="focus-input100" data-symbol="&#xf206;"></span>
        @error('nama_panggilan')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="wrap-input100 m-b-23" >
        <span class="label-input100">No Hp</span>
        <input class="input100"  value="{{ old('no_hp') }}"type="text" name="no_hp" placeholder="Type your phone">
        <span class="focus-input100" data-symbol="&#xf206;"></span>
        @error('no_hp')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="wrap-input100 m-b-23" >
        <span class="label-input100">Email</span>
        <input class="input100" value="{{ old('email') }}" type="text" name="email" placeholder="Type your email">
        <span class="focus-input100" data-symbol="&#xf206;"></span>
        @error('email')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="wrap-input100" >
        <span class="label-input100">Password</span>
        <input class="input100" type="password" name="password" placeholder="Type your password">
        <span class="focus-input100" data-symbol="&#xf190;"></span>
        @error('password')
           <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="text-right p-t-8 p-b-31"></div>
    <div class="wrap-input100" >
        <span class="label-input100">Ulangi Password</span>
        <input class="input100" type="password" name="password_confirmation" placeholder="Retype your password">
        <span class="focus-input100" data-symbol="&#xf190;"></span>
    </div>
    <div class="text-right p-t-8 p-b-31"></div>
    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn">
                Register
            </button>
        </div>
    </div>
    <div class="flex-col-c p-t-155">
        <span class="txt1 p-b-17">
            Sudah Punya Akun.?
        </span>

    <a href="{{ route('login.index') }}" class="txt2">
            login
        </a>
    </div>
</form>
@endsection
