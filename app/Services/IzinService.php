<?php
namespace App\Services;
use App\Repositories\IzinRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class IzinService{

    protected $izinRepository;

    public function __construct(IzinRepository $izinRepository){

        $this->izinRepository = $izinRepository;

    }

    public function izin($request){

        $dataIzin = $this->izinRepository->dataIzin();

        if($request['waktu_mulai'] >= Carbon::now()->toDateString()){

            foreach($dataIzin as $data){

                if($data->waktu_mulai == $request['waktu_mulai']
                || $data->waktu_selesai == $request['waktu_selesai']){
                    dd('ok');
                }

                if($request['waktu_mulai'] <= $data->waktu_selesai && $data->waktu_mulai <= $request['waktu_mulai']){
                    dd('ok');
                }


            }
            if($request['waktu_mulai'] <= $request['waktu_selesai']){

                $period = CarbonPeriod::create($request['waktu_mulai'], $request['waktu_selesai']);

                foreach ($period as $date) {

                    $tgl = $date->format('Y-m-d');

                    // $this->izinRepository->absen($tgl);
                }

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

}
