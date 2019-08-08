<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AntrianPasien;

class AntrianController extends Controller
{
    public function index()
    {
        $antrians = DB::table('view_antrian_dokter')->get();
        return view('antrian_dokter.index',compact('antrians'));
    }

    public function update($id)
    {
        AntrianPasien::whereId($id)->update([
            'status' => '1'
        ]);
        return response()->json(["Message" => "Berhasil"]);
    }

    public function getListPasien($id_dokter)
    {

        $data = DB::table('view_list_antrian')->where('id_dokter',$id_dokter)->get();
        return Datatables($data)
                ->addIndexColumn()
                ->addColumn('status',function($data){
                    if ($data->status == '0') {
                        return 'Belum Selesai';
                    }else{
                        return 'Selesai';

                    }
                })
                ->addColumn('nama_lengkap',function($data){
                    return '<a href="#" id="pasien" id-antrian="'.$data->id.'" id-pasien="'.$data->id_pasien.'">'.$data->nama_lengkap.'</a>';
                })
                ->rawColumns(['nama_lengkap'=>'nama_lengkap'])
                ->toJson();
    }

    public function getProfilePasien($id_pasien,$id_antrian){

        $pasien = DB::table("master_pasien")->where('id',$id_pasien)->first();
        $antrian = DB::table("tb_antrian")
                        ->leftJoin('master_asuransi_pasien', 'tb_antrian.id_asuransi', '=', 'master_asuransi_pasien.id')
                        ->leftJoin('master_asuransi', 'master_asuransi_pasien.asuransi_id', '=', 'master_asuransi.id')
                        ->select('tb_antrian.*','master_asuransi_pasien.foto_asuransi','master_asuransi.nama_asuransi')
                        ->where('tb_antrian.id',$id_antrian)->first();
        return response()->json(compact('pasien','antrian'));
    }

}
