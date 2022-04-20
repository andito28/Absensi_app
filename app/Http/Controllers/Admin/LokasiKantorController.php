<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LokasiKantor;

class LokasiKantorController extends Controller
{
    public function index(){
        $lokasi = LokasiKantor::first();
        return view('lokasi-kantor.index',compact('lokasi'));
    }

    public function update(Request $request){

        $id = $request->id;
        $lokasi = LokasiKantor::findOrFail($id);
        $lokasi->titik_koordinat = $request->lokasi_kantor;
        $lokasi->ket = $request->ket;
        $lokasi->save();
        return response()->json($lokasi);

    }
}
