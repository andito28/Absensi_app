<?php
namespace App\Repositories;
use App\Models\Absen;
use App\Models\Izin;
use Auth;

class IzinRepository{

    public function izin($data){
        $izin = new Izin();
        $izin->user_id = Auth::user()->id;
        $izin->jenis_izin = $data->jenis_izin;
        $izin->waktu_mulai = $data->waktu_mulai;
        $izin->waktu_selesai = $data->waktu_selesai;
        $izin->ket = $data->ket;
        $izin->status = 'proses';
        $izin->save();
        return $izin->fresh();
    }

    public function dataIzin(){
        $izin = Izin::where('user_id', Auth::user()->id)
        ->get();
        return $izin;
    }

        public function dataAbsen($date){
        $data_absen = Absen::where('user_id',Auth::user()->id)
        ->where('tgl',$date)
        ->first();
        return $data_absen;
    }

    public function getIzin(){
        $daftar_izin = Izin::select('jenis_izin','waktu_mulai','waktu_selesai','ket','status')
        ->where('user_id', Auth::user()->id)
        ->paginate(5);
        return $daftar_izin;
    }

    // public function absen($tgl){
    //     $absen = new Absen();
    //     $absen->user_id = Auth::user()->id;
    //     $absen->tgl = $tgl;
    //     $absen->jam_masuk = null;
    //     $absen->jam_pulang = null;
    //     $absen->status = 'IZIN';
    //     $absen->koordinat = null;
    //     $absen->jenis_absen = null;
    //     $absen->save();
    //     return $absen->fresh();
    // }

}
