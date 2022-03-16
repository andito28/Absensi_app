<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Izin;
use Carbon\Carbon;
use Auth;

class AbsensiController extends Controller
{
    public function absenMasuk(Request $request){

        $now = Carbon::now();
        $late = new Carbon('08:15:00');

        $status = "";
        $jam_masuk = $now->toTimeString();
        $jam_pulang = null;
        $jenis_absen = $request->jenis_absen;
        $koordinat = $request->koordinat;

        $izin = Izin::where('user_id', Auth::user()->id)
        ->latest('waktu_selesai')
        ->first();

        $data_absen = Absen::where('user_id',Auth::user()->id)
        ->where('tgl',$now->toDateString())
        ->first();

        if(empty($data_absen)){

            if(!empty($izin &&  $now->toDateString() >= $izin->waktu_mulai && $now->toDateString() <= $izin->waktu_selesai)){

                $jam_masuk = null;
                $jam_pulang = null;
                $jenis_absen = null;
                $koordinat = null;
                $status = 'IZIN';

            }else{
                    if($now->toTimeString() > $late->toTimeString()){
                        $status = 'TERLAMBAT';
                    }else{
                        $status = 'HADIR';
                    }
            }

        }else{
            return response()->json([
                'message' => 'User Telah Melakukan Absen Masuk'
            ]);

        }


            $absen = new Absen();
            $absen->user_id = Auth::user()->id;
            $absen->tgl = $now->toDateString();
            $absen->jam_masuk = $jam_masuk;
            $absen->jam_pulang = $jam_pulang;
            $absen->status = $status;
            $absen->koordinat = $koordinat;
            $absen->jenis_absen = $jenis_absen;
            $absen->save();

            return response()->json([
                'message' => 'Success Create Absen',
                'data' => $absen
            ]);
    }
}
