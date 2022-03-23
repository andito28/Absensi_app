<?php
namespace App\Repositories;
use App\Models\Absen;
use App\Models\Izin;
use App\Models\Sakit;
use App\Models\User;
use Auth;


class AbsensiRepository{

    public function absenMasuk($data,$dateTime){

        $absen_masuk = new Absen();
        $absen_masuk->user_id = Auth::user()->id;
        $absen_masuk->tgl = $dateTime->toDateString();
        $absen_masuk->jam_masuk = $data['jam_masuk'];
        $absen_masuk->jam_pulang = $data['jam_pulang'];
        $absen_masuk->status = $data['status'];
        $absen_masuk->koordinat = $data['koordinat'];
        $absen_masuk->jenis_absen = $data['jenis_absen'];
        $absen_masuk->save();
        return $absen_masuk->fresh();
    }

    public function dataAbsenMasuk($dateTime){
        $data_absen = Absen::where('user_id',Auth::user()->id)
        ->where('tgl',$dateTime->toDateString())
        ->first();
        return $data_absen;
    }

    public function dataAbsenPulang($dateTime){
        $data_absen = Absen::where('user_id',Auth::user()->id)
        ->where('tgl',$dateTime->toDateString())
        ->first();
        return $data_absen;
    }


   public function absenPulang($data,$dateTime){
        $absen_pulang =  Absen::where('tgl',$dateTime->toDateString())
        ->where('user_id',Auth::user()->id)
        ->first();
        $absen_pulang->jam_pulang = $data['jam_pulang'];
        $absen_pulang->save();
        return $absen_pulang->fresh();
    }


    public function getUserNotAbsen($id,$dateNow){
        $getUserNotAbsen = Absen::select('tgl','user_id')
        ->whereDate('tgl',$dateNow)
        ->where('user_id',$id)
        ->first();
        return   $getUserNotAbsen;
    }

    public function dataUser(){
        $users = User::select('id')
        ->where('role','karyawan')
        ->get();
        return $users;
    }

    public function insertAbsenAlfa($id,$date){
        $absen = new Absen();
        $absen->user_id = $id;
        $absen->status = "TIDAK HADIR";
        $absen->jam_masuk = null;
        $absen->jam_pulang = null;
        $absen->koordinat = null;
        $absen->tgl = $date;
        $absen->jenis_absen = null;
        $absen->save();
        return $absen->fresh();
    }
}
