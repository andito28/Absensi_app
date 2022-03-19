<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\IzinService;

class IzinController extends Controller
{
    protected $izinService;

    public function __construct(IzinService $izinService){

        $this->izinService = $izinService;

    }

    public function izin(Request $request){

        try{
            $data = $this->izinService->izin($request);
        }catch(Error $e){
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json([
            'message' => 'Success Created Izin',
            'data' => $data
        ]);
    }
}
