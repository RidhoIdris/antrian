<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use App\Pasien;
use Illuminate\Support\Facades\DB;

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
            $pasien = Pasien::create([
                'avatar'         => 'default.png',
                'nama_lengkap'   => request('name'),
                'id_user'        => $user->id,
            ]);
            return response()->json(['message'=>'User Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $users = User::with('roles')->orderBy('created_at','DESC')->get();
        return Datatables($users)
                ->addIndexColumn()
                ->addColumn('name',function($data){
                    return '<a href="#" id="pasien" role="'.$data->roles[0]->name.'" id-user="'.$data->id.'">'.$data->name.'</a>';
                })
                ->addColumn('role',function($data){
                    return $data->roles[0]->name;
                })
                ->addColumn('action',function($users){
                    return '<button type="button" data-id="'.$users->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$users->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })
                ->rawColumns(['name'=>'name'])
                ->toJson();
    }

    public function edit($id)
    {
        $user = User::with('roles')->whereId($id)->first();
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),
        [
            'name'       => 'required|max:50',
            'email'      => 'required|max:50|unique:users,email,'.$id,
            'password'   => 'confirmed',
            'role'       => 'required',
        ]
    );

    if ($validator->fails())
    {
        return response()->json(['errors'=>$validator->errors()->first()],422);
    }else{
        $user = User::where('id',$id)->update([
            'email' => $request->email,
            'name' => $request->name,
        ]);
        if ($request->password != null) {
            $user = User::where('id',$id)->update([
                'password' => bcrypt($request->password)
            ]);
        }
        $user = User::findOrFail($id);
        $user->syncRoles([$request->role]);
        return response()->json(['message'=>'User Berhasil Diedit']);
    }
    }

    public function destroy($id)
    {

        // User::findOrFail($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function getProfilePasien($id_pasien){

        $pasien = DB::table("master_pasien")->where('id_user',$id_pasien)->first();
        return response()->json(compact('pasien'));
    }
}
