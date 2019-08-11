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
        COALESCE(tb_antrian.no_antrian,0) as no_antrian
         FROM
        master_jadwal_dokter
         INNER JOIN master_dokter ON master_jadwal_dokter.id_dokter = master_dokter.id
         INNER JOIN master_spesialis ON master_dokter.id_spesialis = master_spesialis.id
         LEFT JOIN tb_antrian on master_jadwal_dokter.id = tb_antrian.id_jadwal and CAST(tb_antrian.created_at as date) = CURRENT_DATE where master_jadwal_dokter.hari = '$dayNow' and tb_antrian.no_antrian = (SELECT max(no_antrian) from tb_antrian where tb_antrian.id_jadwal = master_jadwal_dokter.id
and CAST(tb_antrian.created_at as date) = CURRENT_DATE)" );
        // $dokters = DB::select("SELECT master_dokter.id,nama_dokter,foto,nama_spesialis,COALESCE(max(tb_antrian.no_antrian),0) as no_antrian from master_jadwal_dokter left join tb_antrian on tb_antrian.id_dokter=master_jadwal_dokter.id_dokter and CAST(tb_antrian.created_at as date) = CURRENT_DATE join master_dokter on master_dokter.id = master_jadwal_dokter.id_dokter
        // join master_spesialis on master_spesialis.id = master_dokter.id_spesialis
        // where master_jadwal_dokter.hari='$dayNow'
        // GROUP BY nama_dokter,nama_spesialis,foto,master_dokter.id
        // ");
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
        $cek = DB::table('master_pasien')
                    ->orWhereNull('nama_lengkap')
                    ->orWhere('nama_lengkap','')
                    ->orWhereNull('nama_panggilan')
                    ->orWhere('nama_panggilan','')
                    ->orWhereNull('jenis_kelamin')
                    ->orWhere('jenis_kelamin','')
                    ->orWhereNull('tanggal_lahir')
                    ->orWhereNull('no_identitas')
                    ->orWhere('no_identitas','')
                    ->orWhereNull('agama')
                    ->orWhere('agama','')
                    ->orWhereNull('pendidikan')
                    ->orWhere('pendidikan','')
                    ->orWhereNull('no_hp')
                    ->orWhere('no_hp','')
                    ->orWhereNull('alamat')
                    ->orWhere('alamat','')
                    ->orWhereNull('alamat_pj')
                    ->orWhere('alamat_pj','')
                    ->orWhereNull('nama_pj')
                    ->orWhere('nama_pj','')
                    ->orWhereNull('hubungan')
                    ->orWhere('hubungan','')
                    ->orWhereNull('no_hp_pj')
                    ->orWhere('no_hp_pj','')
                    ->where('id',$pasien)
                    ->first();
        if ($cek) {
            return response()->json(['errors'=>'Silahkan Lengkapi Profile Anda TerlebihDahulu'],422);
        }else{
            $cek = DB::table('tb_antrian')
            ->whereDate('created_at',Carbon::today())
            ->where('id_dokter',$request->id_dokter)
            ->where('id_jadwal',$request->id_jadwal)
            ->where('id_pasien',$pasien)
            ->where('status','0')
            ->where('id_dokter',$request->id_dokter)
            ->first();
            if (!$cek) {
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
