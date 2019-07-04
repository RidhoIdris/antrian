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
}
