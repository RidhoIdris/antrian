<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterAsuransi;

class MasterAsuransiController extends Controller
{
    public function index()
    {
        return view('master_asuransi.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'nama_asuransi' => 'required|max:50|unique:master_asuransi,nama_asuransi',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            MasterAsuransi::create([
                'nama_asuransi'=> request('nama_asuransi'),
            ]);
            return response()->json(['message'=>'Asuransi Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $masuransi = MasterAsuransi::orderBy('created_at','DESC')->get();
        return Datatables($masuransi)
                ->addIndexColumn()
                ->addColumn('action',function($masuransi){
                    return '<button type="button" data-id="'.$masuransi->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$masuransi->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })->toJson();
    }

    public function edit($id)
    {
        $masuransi = MasterAsuransi::whereId($id)->first();
        return response()->json($masuransi);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),
            [
                'nama_asuransi' => 'required|max:50|unique:master_asuransi,nama_asuransi,'.$id,
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            MasterAsuransi::where(['id'=>$id])->update([
                'nama_asuransi'=> request('nama_asuransi'),
            ]);
            return response()->json(['message'=>'Asuransi Berhasil Diubah']);
        }
    }

    public function destroy($id)
    {
        MasterAsuransi::findOrFail($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
