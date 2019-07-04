<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterAsuransiPasien;
use App\MasterAsuransi;
use Illuminate\Support\Facades\DB;
use App\Pasien;

class MasterAsuransiPasienController extends Controller
{
    public function index()
    {
        $masuransi = MasterAsuransi::all();
        return view('master_asuransi_pasien.index',compact('masuransi'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        $id = Pasien::where('id_user','=',\Auth::user()->id)->first()->id;
        $validator = \Validator::make($request->all(),
            [
                'no_asuransi'   => 'required|max:16|unique:master_asuransi_pasien,no_asuransi,null,null,asuransi_id,'.$request->asuransi_id,
                'asuransi_id'   => 'required|max:8',
                'image'         => 'required|image|mimes:jpeg,png,jpg|max:1024',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images/asuransi-pasien'), $imageName);
            MasterAsuransiPasien::create([
                'asuransi_id'   => request('asuransi_id'),
                'no_asuransi'   => request('no_asuransi'),
                'pasien_id'     => $id,
                'foto_asuransi' => $imageName
            ]);
            return response()->json(['message'=>'Asuransi Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $id = \Auth::user()->id;
        $mapasien = DB::table('view_asuransi_pasien')->whereUser_id($id)->get();

        return Datatables($mapasien)
                ->addIndexColumn()
                ->addColumn('foto',function($mapasien){
                    return '<img src="'.asset("images/asuransi-pasien")."/".$mapasien->foto_asuransi.'" alt="profile image">';
                })->addColumn('action',function($mapasien){
                    return '<button type="button" data-id="'.$mapasien->asuransi_pasien_id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$mapasien->asuransi_pasien_id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })->rawColumns(['foto'=>'foto','action'=>'action'])
                ->toJson();
    }

    public function edit($id)
    {
        $mapasien = MasterAsuransiPasien::whereId($id)->first();
        return response()->json($mapasien);
    }

    public function update(Request $request, $id)
    {

        if ($request->image == 'undefined') {
            $validator = \Validator::make($request->all(),
                [
                    'no_asuransi'   => 'required|max:16|unique:master_asuransi_pasien,no_asuransi,'.$id.',id,asuransi_id,'.$request->asuransi_id,
                    'asuransi_id'   => 'required|max:8',
                ]
            );

            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->first()],422);
            }else{
                MasterAsuransiPasien::where(['id'=>$id])->update([
                    'asuransi_id'   => request('asuransi_id'),
                    'no_asuransi'   => request('no_asuransi'),
                ]);
                return response()->json(['message'=>'Asuransi Berhasil Diubah']);
            }
        }else{
            $validator = \Validator::make($request->all(),
                [
                    'no_asuransi'   => 'required|max:16|unique:master_asuransi_pasien,no_asuransi,'.$id.',id,asuransi_id,'.$request->asuransi_id,
                    'asuransi_id'   => 'required|max:8',
                    'image'         => 'image|mimes:jpeg,png,jpg|max:1024',
                ]
            );

            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->first()],422);
            }else{
                $oldImage = MasterAsuransiPasien::where('id','=',$id)->first()->foto_asuransi;
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images/asuransi-pasien'), $imageName);
                MasterAsuransiPasien::where(['id'=>$id])->update([
                    'asuransi_id'   => request('asuransi_id'),
                    'no_asuransi'   => request('no_asuransi'),
                    'foto_asuransi'         => $imageName
                ]);
                @unlink(public_path('images/asuransi-pasien/').$oldImage);
                return response()->json(['message'=>'Asuransi Berhasil Diubah']);
            }
        }

    }

    public function destroy($id)
    {
        $oldImage = MasterAsuransiPasien::where('id','=',$id)->first()->foto_asuransi;
        MasterAsuransiPasien::findOrFail($id)->delete($id);
        @unlink(public_path('images/asuransi-pasien/').$oldImage);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
