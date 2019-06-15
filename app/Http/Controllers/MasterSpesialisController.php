<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterSpesialis;

class MasterSpesialisController extends Controller
{

    public function index()
    {
        return view('master_spesialis.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'nama_spesialis' => 'required|max:50|unique:master_spesialis,nama_spesialis',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            MasterSpesialis::create([
                'nama_spesialis'=> request('nama_spesialis'),
            ]);
            return response()->json(['message'=>'Spesialis Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $mspesialis = MasterSpesialis::orderBy('created_at','DESC')->get();
        return Datatables($mspesialis)
                ->addIndexColumn()
                ->addColumn('action',function($mspesialis){
                    return '<button type="button" data-id="'.$mspesialis->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$mspesialis->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })->toJson();
    }

    public function edit($id)
    {
        $mspesialis = MasterSpesialis::whereId($id)->first();
        return response()->json($mspesialis);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),
            [
                'nama_spesialis' => 'required|max:50|unique:master_spesialis,nama_spesialis,'.$id,
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            MasterSpesialis::where(['id'=>$id])->update([
                'nama_spesialis'=> request('nama_spesialis'),
            ]);
            return response()->json(['message'=>'Spesialis Berhasil Diubah']);
        }
    }

    public function destroy($id)
    {
        MasterSpesialis::findOrFail($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
