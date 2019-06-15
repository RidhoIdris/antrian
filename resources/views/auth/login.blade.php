@extends('layouts.master_auth')
@section('content')
@if (session('danger'))
    <div style="margin-top: -50px;" align="center" class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('danger')}}</strong>
    </div>
@endif
@if (session('success'))
    <div style="margin-top: -50px;" align="center" class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{session('success')}}</strong>
    </div>
@endif
<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
    @csrf
    <span class="login100-form-title p-b-49">
        Login
    </span>

    <div class="wrap-input100 m-b-23" >
        <span class="label-input100">Email</span>
        <input class="input100" type="email" name="email" placeholder="Type your email">
        <span class="focus-input100" data-symbol="&#xf206;"></span>
    </div>

    <div class="wrap-input100">
        <span class="label-input100">Password</span>
        <input class="input100" type="password" name="pass" placeholder="Type your password">
        <span class="focus-input100" data-symbol="&#xf190;"></span>
    </div>
    <div class="text-right p-t-8 p-b-31"></div>
    <div class="container-login100-form-btn">
        <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn">
                Login
            </button>
        </div>
    </div>
    <div class="flex-col-c p-t-155">
        <span class="txt1 p-b-17">
            Belum Punya Akun.?
        </span>

        <a href="{{ route('register')  }}" class="txt2">
            Register
        </a>
    </div>
</form>
@endsection
