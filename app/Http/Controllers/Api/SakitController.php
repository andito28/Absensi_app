<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SakitService;

class SakitController extends Controller
{
    protected $sakitService;

    public function __construct(SakitService $sakitService){

        $this->sakitService = $sakitService;

    }

    public function sakit(Request $request){

        try{
            $data = $this->sakitService->sakit($request);
        }catch(Error $e){
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([
            'message' => 'Berhasil Melakukan Pengajuan Sakit',
            'data' => $data
        ]);
    }

    public function daftarSakit(){

        $data = $this->sakitService->daftarSakit();
        return response()->json([
            'message' => 'Daftar Pengajuan Sakit',
            'data' => $data
        ]);

    }
}
