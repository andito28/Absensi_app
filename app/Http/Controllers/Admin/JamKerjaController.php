<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamKerja;

class JamKerjaController extends Controller
{
    public function index(){
        $jamKerja = JamKerja::first();
        return view('jam-kerja.index',compact('jamKerja'));
    }

    public function update(Request $request){

        $id = $request->id;
        $jamKerja = JamKerja::findOrFail($id);
        $jamKerja->jam_masuk = $request->jam_masuk;
        $jamKerja->jam_pulang = $request->jam_pulang;
        $jamKerja->save();
        return response()->json($jamKerja);

    }
}
