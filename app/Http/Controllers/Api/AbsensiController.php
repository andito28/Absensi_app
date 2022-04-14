<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AbsensiService;

class AbsensiController extends Controller
{
    protected $absensiService;

    public function __construct(AbsensiService $absensiService){
        $this->absensiService = $absensiService;
    }


    public function absenMasuk(Request $request){
        try{
            $data = $this->absensiService->absenMasuk($request);

        }catch(Error $e){
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
            return response()->json([
                'message' => 'Berhasil Melakukan Absen Datang',
                'data' => $data
            ]);
    }


    public function absenPulang(Request $request){
        try{
            $data = $this->absensiService->absenPulang($request);
        }catch(Error $e){
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
            return response()->json([
                'message' => 'Berhasil Melakukan Absen Pulang',
                'data' => $data
            ]);
    }

    public function getCountAbsensi(){
        $data = $this->absensiService->getAbsen();
        return response()->json([
            'data' => $data
        ]);
    }

    public function cekAbsenMasuk(){
        return $this->absensiService->cekAbsenMasuk();
    }

    public function cekAbsenPulang(){
        return  $this->absensiService->cekAbsenPulang();
    }

}
