<?php

namespace App\Http\Controllers;

use App\MasterDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PrintController extends Controller
{
    public function index(){
        $mdokter = MasterDokter::all();
        return view('print.index',compact('mdokter'));
    }

    public function cetak(Request $request)
    {
        $validator = \Validator::make($request->all(),
            [
                'dokter' => 'required',
                'from'   => 'required',
                'to'     => 'required|after:from',
            ]
        );

        if ($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            if ($request->dokter=='all') {
                $datas = DB::table('view_print')
                        ->whereBetween('created_at',[$request->from,$request->to])
                        ->get();
            }else{
                $datas = DB::table('view_print')
                        ->where('id_dokter',$request->id)
                        ->whereBetween('created_at',[$request->from,$request->to])
                        ->get();
            }
            $pdf = PDF::loadView('print.cetak',compact('datas'))->setPaper('a4','landscape');
            return $pdf->stream('Laporan Antrian'.'.pdf');
        }

    }
}
