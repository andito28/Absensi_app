<?php
namespace App\Repositories;
use App\Models\Sakit;
use App\Models\Absen;
use Auth;

class SakitRepository{

    public function sakit($data){
       $sakit = new Sakit();
       $sakit->user_id = Auth::user()->id;
       $sakit->waktu = $data['waktu'];
       $sakit->ket = $data['ket'];
       $sakit->status = 'proses';
       $sakit->save();
       return $sakit->fresh();
    }

    public function dataSakit($date){
        $data_sakit = Sakit::where('user_id',Auth::user()->id)
        ->where('waktu',$date)
        ->first();
        return $data_sakit;
    }

    // public function dataAbsen($date){
    //     $data_absen = Absen::where('user_id',Auth::user()->id)
    //     ->where('tgl',$date)
    //     ->first();
    //     return $data_absen;
    // }

    // public function absen($date){
    //     $absen = new Absen();
    //     $absen->user_id = Auth::user()->id;
    //     $absen->tgl = $date['waktu'];
    //     $absen->jam_masuk = null;
    //     $absen->jam_pulang = null;
    //     $absen->status = 'SAKIT';
    //     $absen->koordinat = null;
    //     $absen->jenis_absen = null;
    //     $absen->save();
    //     return $absen->fresh();
    // }


}
