<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LaporanKunjunganService;

class LaporanKunjunganController extends Controller
{
    protected $laporanKunjunganService;

    public function __construct(LaporanKunjunganService $laporanKunjunganService){

        $this->laporanKunjunganService = $laporanKunjunganService;

    }

    public function laporanKunjungan(request $request){

        try{
            $data = $this->laporanKunjunganService->laporan($request);
        }catch(Error $e){
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        return response()->json([
            'message' => 'Laporan Kunjungan Berhasil Terkirim',
            'data' => $data
        ]);
    }
}
