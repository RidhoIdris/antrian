<?php

namespace App\Http\Controllers;

use App\MasterAsuransi;
use App\MasterDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PrintController extends Controller
{
    public function index(){
        $mdokter = MasterDokter::all();
        $asuransi = MasterAsuransi::all();
        return view('print.index',compact('mdokter','asuransi'));
    }

    public function cetak(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                // 'dokter' => 'required',
                'from'   => 'required',
                'to'     => 'required|after:from',
            ]
        );

        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $datas = DB::table('view_print')->whereBetween('created_at',[$request->from,$request->to]);

            if($request->tipe_pembayaran){
                $datas = $datas->where('tipe_pembayaran',$request->tipe_pembayaran);
            }
            if($request->asuransi){
                $datas = $datas->where('nama_asuransi',$request->asuransi);
            }
            if($request->dokter){
                $datas = $datas->where('id_dokter',$request->dokter);
            }
            $datas = $datas->get();
            $pdf = PDF::loadView('print.cetak',compact('datas'))->setPaper('a4','landscape');
            return $pdf->stream('Laporan Antrian'.'.pdf');
        }

    }
}
