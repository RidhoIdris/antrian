<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use App\Pasien;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|email|max:50|unique:users,email',
                'nama_lengkap' => 'required|max:50',
                'nama_panggilan' => 'required|max:50',
                'no_hp' => 'required|numeric|digits_between:1,13',
                'password' => 'required|confirmed|max:50',
            ]
        );
        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);;
        }else
        {
            $user = User::create([
            'email'    => request('email'),
            'password' => bcrypt(request('password')),
            ])->assignRole('pasien');

            $pasien = Pasien::create([
                'avatar'         => 'default.png',
                'nama_lengkap'   => request('nama_lengkap'),
                'nama_panggilan' => request('nama_panggilan'),
                'no_hp'          => request('no_hp'),
                'id_user'        => $user->id,
            ]);
            return redirect()->route('login.index')->withSuccess('Register Berhasil, Silahkan Login');
        }
    }

    public function login(Request $request)
    {
    	if (!\Auth::attempt([
    		'email'    => request('email'),
    		'password' => request('pass')
    	])) {
    		return redirect()->back()->withDanger('Email Atau Password Salah');
    	}else{
    		return redirect()->route('home');
    	}
    }

    public function logout()
    {
    	\Auth::logout();

    	return redirect('admin/');
    }
}
