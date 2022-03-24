<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LaporanHarianService;

class LaporanHarianController extends Controller
{

    protected $laporanHarianService;

    public function __construct(LaporanHarianService $laporanHarianService){

        $this->laporanHarianService = $laporanHarianService;

    }

    public function laporanHarian(request $request){

        try{
            $data = $this->laporanHarianService->laporan($request);
        }catch(Error $e){
            $data = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        return response()->json([
            'message' => 'Laporan Harian Berhasil Terkirim',
            'data' => $data
        ]);

    }
}
