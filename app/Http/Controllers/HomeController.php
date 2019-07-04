<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\MasterAsuransi;
use App\AntrianPasien;
use App\Pasien;

class HomeController extends Controller
{

    public function index()
    {
        $masuransi = DB::table('view_asuransi_pasien')->where('user_id','=',\Auth::user()->id)->get();
        $dayNow = $this->converthari(Carbon::now()->format('D'));
        $dokters = DB::select("SELECT master_dokter.id,nama_dokter,foto,nama_spesialis,COALESCE(max(tb_antrian.no_antrian),0) as no_antrian from master_jadwal_dokter left join tb_antrian on tb_antrian.id_dokter=master_jadwal_dokter.id_dokter and CAST(tb_antrian.created_at as date) = CURRENT_DATE join master_dokter on master_dokter.id = master_jadwal_dokter.id_dokter
        join master_spesialis on master_spesialis.id = master_dokter.id_spesialis
        where master_jadwal_dokter.hari='$dayNow' and jam_mulai <= CURRENT_TIME and jam_selesai >= CURRENT_TIME
        GROUP BY nama_dokter,nama_spesialis,foto,master_dokter.id
        ");
        return view('antrian.index',compact('dokters','masuransi'));
    }

    public function converthari($date)
    {
        if ($date == 'Sun') {
            return "Minggu";
        }elseif($date == 'Mon'){
            return "Senin";
        }elseif($date == 'Tue'){
            return "Selasa";
        }elseif($date == 'Wed'){
            return "Rabu";
        }elseif($date == 'Thu'){
            return "Kamis";
        }elseif($date == 'Fri'){
            return "Jumat";
        }elseif($date == 'Sat'){
            return "Sabtu";
        }
    }

    public function store(Request $request)
    {
        $pasien = Pasien::where('id_user','=',\Auth::user()->id)->first()->id;
        $dayNow = Carbon::now()->format('D');
        $time = date('H:i:s');
        $validator = \Validator::make($request->all(),
            [
                'tipe_pembayaran' => 'required|max:10',
                "id_asuransi"     => "required_if:tipe_pembayaran,==,Asuransi"
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            AntrianPasien::create([
                'id_dokter'       => request('id_dokter'),
                'no_antrian'      => request('no_antrian'),
                'tipe_pembayaran' => request('tipe_pembayaran'),
                'id_asuransi'     => request('id_asuransi'),
                'status'          => '0',
                'id_pasien'       => $pasien,
                'jam'             => $time,
                'hari'            => $dayNow,
            ]);
            return response()->json(['message'=>'Berhasil Mengambil Antrial']);
        }
    }
}
