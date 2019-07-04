<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterDokter;
use App\MasterSpesialis;

class MasterDokterController extends Controller
{
    public function index()
    {
        $mspesialis = MasterSpesialis::all();
        return view('master_dokter.index',compact('mspesialis'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(),
            [
                'nama_dokter'  => 'required|max:50|unique:master_dokter,nama_dokter',
                'id_spesialis' => 'required|max:50',
                'image'        => 'required|image|mimes:jpeg,png,jpg|max:1024',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images/dokter'), $imageName);
            MasterDokter::create([
                'nama_dokter'  => request('nama_dokter'),
                'id_spesialis' => request('id_spesialis'),
                'foto'         => $imageName
            ]);
            return response()->json(['message'=>'Dokter Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $mdokter = MasterDokter::orderBy('created_at','DESC')->get();
        return Datatables($mdokter)
                ->addIndexColumn()
                ->addColumn('spesialis',function($mdokter){
                    return $mdokter->master_spesialis->nama_spesialis;
                })
                ->addColumn('foto',function($mdokter){
                    return '<img src="'.asset("images/dokter")."/".$mdokter->foto.'" alt="profile image">';
                })
                ->addColumn('action',function($mdokter){
                    return '<button type="button" data-id="'.$mdokter->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$mdokter->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })
                ->rawColumns(['foto'=>'foto','action'=>'action'])
                ->toJson();
    }

    public function edit($id)
    {
        $mdokter = MasterDokter::whereId($id)->first();
        return response()->json($mdokter);
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
