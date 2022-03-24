<?php
namespace App\Repositories;
use App\Models\LaporanHarian;
use Auth;

class LaporanHarianRepository{

    public function insertLaporan($data,$dateTime){
        $laporan = new LaporanHarian();
        $laporan->user_id = Auth::user()->id;
        $laporan->waktu = $dateTime;
        $laporan->ket = $data['ket'];
        $laporan->save();
        return $laporan->fresh();
    }
}
