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

        if($data['waktu'] >= $dateTime->toDateString()){

            $data_sakit = $this->sakitRepository->dataSakit($data['waktu']);

            if(empty($data_sakit)){

                // $this->sakitRepository->absen($data);
                return $this->sakitRepository->sakit($data);

            }else{

                throw new HttpResponseException(response()->json([

                    'message' => 'Anda Sudah Melakukan Pengajuan Sakit'
                ],500));

            }

        }else{

            throw new HttpResponseException(response()->json([

                'message' => 'Tanggal Tidak Valid'

            ],500));
        }


    }
}
