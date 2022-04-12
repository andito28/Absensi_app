<?php
namespace App\Services;
use App\Repositories\IzinRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class IzinService{

    protected $izinRepository;
    protected $message;

    public function __construct(IzinRepository $izinRepository){

        $this->izinRepository = $izinRepository;

    }

    public function izin($request){

        $dataIzin = $this->izinRepository->dataIzin();

        $this->message = 'Tidak Dapat Melakukan Izin';

        if($request['waktu_mulai'] >= Carbon::now()->toDateString()){

            $data_absen = $this->izinRepository->dataAbsen($request['waktu_mulai']);

            if(!empty($data_absen)){
                throw new HttpResponseException(response()->json([
                    'message' => $this->message
                    ],500));
            }

            foreach($dataIzin as $data){

                if($data->waktu_mulai == $request['waktu_mulai']
                || $data->waktu_selesai == $request['waktu_selesai']){
                    throw new HttpResponseException(response()->json([
                        'message' => $this->message
                        ],500));
                }

                if($request['waktu_mulai'] <= $data->waktu_selesai && $data->waktu_mulai <= $request['waktu_mulai']){
                    throw new HttpResponseException(response()->json([
                        'message' => $this->message
                        ],500));
                }

                if($data->waktu_mulai >= $request['waktu_mulai'] && $request['waktu_selesai'] >= $data->waktu_mulai){
                    throw new HttpResponseException(response()->json([
                        'message' => $this->message
                        ],500));
                }

            }
            if($request['waktu_mulai'] <= $request['waktu_selesai']){

                // $period = CarbonPeriod::create($request['waktu_mulai'], $request['waktu_selesai']);

                // foreach ($period as $date) {
                //     $tgl = $date->format('Y-m-d');
                //     $data_absen = $this->izinRepository->dataAbsen($tgl);
                //     if(empty($data_absen)){
                //         $this->izinRepository->absen($tgl);
                //     }
                // }

                return $this->izinRepository->izin($request);

                }else{
                    throw new HttpResponseException(response()->json([
                        'message' => 'Tanggal Izin tidak valid'
                        ],500));
                }
        }else{
            throw new HttpResponseException(response()->json([
                'message' => 'Tanggal Izin tidak valid'
                ],500));
        }

    }

    public function daftarIzin(){
        return $this->izinRepository->getIzin();
    }

}
