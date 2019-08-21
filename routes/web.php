<?php

Route::get('/',function(){
    return redirect()->route('home.index');
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
            return redirect()->route('home.index');
        });
        Route::get('/dashboard',function(){
            return redirect()->route('home.index');
        });
        Route::get('/',function(){
            return redirect()->route('home.index');
        });
        Route::get('/profile', 'PasienController@index')->name('profile.index');
        Route::get('/test', function(){
            return csrf_token();
            die();
        });
        Route::PUT('/profile/{id_user}/{id_pasien}/info', 'PasienController@info')->name('profile.info');
        Route::PUT('/profile/{profile}/avatar', 'PasienController@avatar')->name('profile.avatar');
        Route::PUT('/profile/{profile}/penjamin', 'PasienController@penjamin')->name('profile.penjamin');
        Route::PUT('/profile/{profile}/password', 'PasienController@password')->name('profile.password');
        Route::POST('/logout', 'AuthController@logout')->name('logout');
        Route::GET('/home', 'HomeController@index')->name('home.index');
        Route::GET('/laporan', 'PrintController@index')->name('print.index');
        Route::POST('/laporan', 'PrintController@cetak')->name('print.cetak');
        Route::GET('/antrian', 'AntrianController@index')->name('antrian.index');
        Route::PUT('/antrian/{antrian}', 'AntrianController@update');
        Route::GET('/antrian/getprofilepasien/{id_pasien}/{id_antrian}', 'AntrianController@getProfilePasien');
        Route::GET('/antrian/getpasien/{id_dokter}', 'AntrianController@getListPasien');
        Route::POST('/home', 'HomeController@store')->name('home.store');
        Route::resource('master-dokter','MasterDokterController');
        Route::resource('master-spesialis','MasterSpesialisController');
        Route::resource('master-asuransi','MasterAsuransiController');
        Route::resource('master-asuransi-pasien','MasterAsuransiPasienController');
        Route::resource('master-jadwal-dokter','JadwalDokterController');
        Route::resource('master-user','MasterUserController');
        Route::GET('/master-user/getprofilepasien/{id_pasien}', 'MasterUserController@getProfilePasien');
    });
});
