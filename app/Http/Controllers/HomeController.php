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
        $dokters = DB::select("SELECT DISTINCT
        master_dokter.id,
        master_jadwal_dokter.id as id_jadwal,
        master_dokter.foto,
        master_dokter.nama_dokter,
        master_jadwal_dokter.hari,
        master_spesialis.nama_spesialis,
        master_jadwal_dokter.jam_mulai,
        master_jadwal_dokter.jam_selesai,
        COALESCE(max(tb_antrian.no_antrian),0) as no_antrian
         FROM
        master_jadwal_dokter
         INNER JOIN master_dokter ON master_jadwal_dokter.id_dokter = master_dokter.id
         INNER JOIN master_spesialis ON master_dokter.id_spesialis = master_spesialis.id
         LEFT JOIN tb_antrian on master_jadwal_dokter.id = tb_antrian.id_jadwal and CAST(tb_antrian.created_at as date) = CURRENT_DATE where master_jadwal_dokter.hari = '$dayNow' GROUP BY master_dokter.id, master_jadwal_dokter.id, master_spesialis.nama_spesialis" );
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
        $cek1 = DB::table('vw_cek_profile')
                    ->where('id_user',\Auth::user()->id)
                    ->first();
        if ($cek1) {
            return response()->json(['errors'=>'Silahkan Lengkapi Profile Anda Terlebih Dahulu'],422);
        }else{
            $cek2 = DB::table('tb_antrian')
            ->whereDate('created_at',Carbon::today())
            ->where('id_dokter',$request->id_dokter)
            ->where('id_jadwal',$request->id_jadwal)
            ->where('id_pasien',$pasien)
            ->where('status','0')
            ->where('id_dokter',$request->id_dokter)
            ->first();
            if ($cek2) {
                return response()->json(['errors'=>'Anda Sudah Mengambil Antrian Untuk Dokter Ini'],422);
            }else{
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
                        'id_jadwal'       => request('id_jadwal'),
                        'no_antrian'      => request('no_antrian'),
                        'tipe_pembayaran' => request('tipe_pembayaran'),
                        'id_asuransi'     => request('id_asuransi'),
                        'status'          => '0',
                        'id_pasien'       => $pasien,
                        'jam'             => $time,
                        'hari'            => $dayNow,
                    ]);
                    return response()->json(['message'=>'Berhasil Mengambil Antrian']);
                }
            }

        }
    }
}
