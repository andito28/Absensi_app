<?php
namespace App\Repositories;
use App\Models\LaporanKunjungan;
use Auth;

class LaporanKunjunganRepository{

    public function insertLaporan($data,$dateTime){
        $laporan = new LaporanKunjungan();
        $laporan->user_id = Auth::user()->id;
        $laporan->waktu = $dateTime;
        $laporan->ket = $data['ket'];
        $laporan->save();
        return $laporan->fresh();
    }

}
