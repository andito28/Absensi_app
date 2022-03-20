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
                'error' => $e->getMessage()
            ];
        }
            return response()->json([
                'message' => 'Success Create Absen Masuk',
                'data' => $data
            ]);
    }


    public function absenPulang(){
        try{
            $data = $this->absensiService->absenPulang();
        }catch(Error $e){
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
            return response()->json([
                'message' => 'Success Create Absen Pulang',
                'data' => $data
            ]);
    }


    public function cekAbsen(){
        $data = $this->absensiService->cekAbsen();
        return response()->json([
            'message' => 'Success Create Absen',
            'data' => $data
        ]);
    }

}
