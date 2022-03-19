<?php

namespace App\Services;
use App\Repositories\SakitRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class SakitService{

    protected $sakitRepository;

    public function __construct(SakitRepository $sakitRepository){
        $this->sakitRepository = $sakitRepository;
    }

    public function sakit($data){

        $dateTime = Carbon::now();

        $data_absen = $this->sakitRepository->dataAbsen($dateTime);

        if(empty($data_absen)){

            $this->sakitRepository->absen($data);
            return $this->sakitRepository->sakit($data);

        }else{

            throw new HttpResponseException(response()->json([

                'message' => 'User Telah Melakukan Absen hari ini / Masa Izin User Belum Selesai'

              ],500));

        }



    }
}
