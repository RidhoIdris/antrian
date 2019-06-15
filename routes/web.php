<?php

Route::get('/',function(){
    return redirect()->route('home');
});
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function(){
        Route::get('/login', 'AuthController@index')->name('login.index');
        Route::POST('/login', 'AuthController@login')->name('login');
        Route::get('/register', 'AuthController@register')->name('register');
        Route::POST('/regiser', 'AuthController@store')->name('register.store');
    });
    Route::middleware('auth')->group(function(){
        Route::get('/',function(){
            return redirect()->route('home');
        });
        Route::get('/profile', 'PasienController@index')->name('profile.index');
        Route::PUT('/profile/{profile}/info', 'PasienController@info')->name('profile.info');
        Route::PUT('/profile/{profile}/avatar', 'PasienController@avatar')->name('profile.avatar');
        Route::PUT('/profile/{profile}/password', 'PasienController@password')->name('profile.password');
        Route::POST('/logout', 'AuthController@logout')->name('logout');
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::resource('master-dokter','MasterDokterController');
        Route::resource('master-spesialis','MasterSpesialisController');
        Route::resource('master-asuransi','MasterAsuransiController');
        Route::resource('master-jadwal-dokter','JadwalDokterController');
    });
});
