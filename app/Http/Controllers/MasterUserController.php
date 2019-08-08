<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class MasterUserController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('master_user.index',compact('roles'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(),
            [
                'name'       => 'required|max:50',
                'email'      => 'required|max:50|unique:users,email',
                'password'   => 'required|confirmed',
                'role'       => 'required',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{

            $user = User::create([
                'name'  => request('name'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
            ])->assignRole($request->role);
            return response()->json(['message'=>'User Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $users = User::orderBy('created_at','DESC')->get();
        return Datatables($users)
                ->addIndexColumn()
                ->addColumn('action',function($users){
                    return '<button type="button" data-id="'.$users->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$users->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })
                ->toJson();
    }

    public function edit($id)
    {
        $user = User::whereId($id)->first();
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        if ($request->image == 'undefined') {
            $validator = \Validator::make($request->all(),
                [
                    'nama_dokter' => 'required|max:50|unique:master_dokter,nama_dokter,'.$id,
                    'id_spesialis' => 'required|max:50',
                ]
            );

            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->first()],422);
            }else{
                MasterDokter::where(['id'=>$id])->update([
                    'nama_dokter'=> request('nama_dokter'),
                    'id_spesialis'=> request('id_spesialis'),
                ]);
                return response()->json(['message'=>'Dokter Berhasil Diubah']);
            }
        }else{
            $validator = \Validator::make($request->all(),
                [
                    'nama_dokter'  => 'required|max:50|unique:master_dokter,nama_dokter,'.$id,
                    'id_spesialis' => 'required|max:50',
                    'image'        => 'image|mimes:jpeg,png,jpg|max:1024',
                ]
            );

            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->first()],422);
            }else{
                $oldImage = MasterDokter::where('id','=',$id)->first()->foto;
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images/dokter'), $imageName);
                MasterDokter::where(['id'=>$id])->update([
                    'nama_dokter'  => request('nama_dokter'),
                    'id_spesialis' => request('id_spesialis'),
                    'foto'         => $imageName,
                ]);
                @unlink(public_path('images/dokter/').$oldImage);
                return response()->json(['message'=>'Asuransi Berhasil Diubah']);
            }
        }
    }

    public function destroy($id)
    {
        $oldImage = MasterDokter::where('id','=',$id)->first()->foto;
        MasterDokter::findOrFail($id)->delete($id);
        @unlink(public_path('images/dokter/').$oldImage);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
