<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterDokter;
use App\JadwalDokter;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $mdokter = MasterDokter::all();
        return view('master_jadwal_dokter.index',compact('mdokter'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(),
            [
                'id_dokter'   => 'required|max:20',
                'hari'        => 'required|max:20',
                'jam_mulai'   => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            JadwalDokter::create([
                'id_dokter'   => request('id_dokter'),
                'hari'        => request('hari'),
                'jam_mulai'   => request('jam_mulai'),
                'jam_selesai' => request('jam_selesai'),
            ]);
            return response()->json(['message'=>'Jadwal Dokter Berhasil Ditambahkan']);
        }
    }

    public function show($id = null)
    {
        $mjdokter = JadwalDokter::join('master_dokter', 'master_dokter.id', '=', 'master_jadwal_dokter.id_dokter')->orderBy('master_dokter.nama_dokter','ASC')->orderBy('master_jadwal_dokter.hari','DESC')->select('master_jadwal_dokter.*')->get();
        return Datatables($mjdokter)
                ->addIndexColumn()
                ->addColumn('dokter',function($mjdokter){
                    return $mjdokter->master_dokter->nama_dokter;
                })
                ->addColumn('action',function($mjdokter){
                    return '<button type="button" data-id="'.$mjdokter->id.'" id="edit" class="btn btn-outline-primary btn-sm">Edit</button>    <button type="button" data-id="'.$mjdokter->id.'" id="hapus" class="btn btn-outline-danger btn-sm">hapus</button>';
                })->toJson();
    }

    public function edit($id)
    {
        $mjdokter = JadwalDokter::whereId($id)->first();
        return response()->json($mjdokter);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(),
            [
                'id_dokter'   => 'required|max: 50',
                'hari'        => 'required|max: 50',
                'jam_mulai'   => 'required|max: 50',
                'jam_selesai' => 'required|max: 50',
            ]
        );

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->first()],422);
        }else{
            JadwalDokter::where(['id'=>$id])->update([
                'id_dokter'   => request('id_dokter'),
                'hari'        => request('hari'),
                'jam_mulai'   => request('jam_mulai'),
                'jam_selesai' => request('jam_selesai'),
            ]);
            return response()->json(['message'=>'Jadwal Dokter Berhasil Diubah']);
        }
    }

    public function destroy($id)
    {
        JadwalDokter::findOrFail($id)->delete($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
