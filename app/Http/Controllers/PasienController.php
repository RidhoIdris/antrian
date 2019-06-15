<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\User;

class PasienController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function info(Request $request,$id)
    {
        $validator = \Validator::make($request->all(),
            [
                'email' => 'required|email|max:50|unique:users,email,'.$id,
                'nama_lengkap' => 'required|max:50',
                'nama_panggilan' => 'required|max:50',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|max:50',
                'jenis_kelamin' => 'required|max:50',
                'alamat' => 'required|max:50',
                'no_hp' => 'required|numeric|digits_between:1,13',
            ]
        );
        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);;
        }else
        {
            $pasien = Pasien::whereId_user($id)->update([
                'nama_lengkap' => request('nama_lengkap'),
                'nama_panggilan' => request('nama_panggilan'),
                'tanggal_lahir' => request('tanggal_lahir'),
                'agama' => request('agama'),
                'jenis_kelamin' => request('jenis_kelamin'),
                'alamat' => request('alamat'),
                'no_hp' => request('no_hp'),
            ]);

            User::whereId($id)->update([
                'email' => request('email')
            ]);

            return redirect()->route('profile.index')->withSuccess('Update Profile Berhasil');
        }
    }

    public function avatar(Request $request,$id)
    {
        request()->validate([

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ]);

        if(\Auth::user()->load('pasien')->pasien->avatar != "default.png"){
            unlink(public_path('images/avatar/'). \Auth::user()->load('pasien')->pasien->avatar);
        }

        $imageName = $id.time().'.'.request()->image->getClientOriginalExtension();

        request()->image->move(public_path('images/avatar'), $imageName);

        Pasien::whereId_user($id)->update([
            'avatar' => $imageName
        ]);
        return redirect()->route('profile.index')->with('success','You have successfully upload image.');
    }

    public function password(Request $request,$id)
    {

        $this->validate($request, [
            'oldpassword' => 'required|max:50',
            'newpassword' => 'confirmed|max:50',
        ]);

        $hashedPassword = \Auth::user()->password;

       if (\Hash::check($request->oldpassword , $hashedPassword )) {

         if (!\Hash::check($request->newpassword , $hashedPassword)) {

            User::whereId($id)->update([
                'password' => bcrypt(request('newpassword'))
            ]);

              return redirect()->back()->withSuccess('success','password updated successfully');
            }

            else{

                  return redirect()->back()->withDanger('new password can not be the old password!');
                }

           }

          else{
               return redirect()->back()->withDanger('old password doesnt matched ');
            }

    }

}
