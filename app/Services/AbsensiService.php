<?php
namespace App\Services;
use App\Repositories\AbsensiRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use Auth;

class AbsensiService{

    protected $absensiRepository;

    public function __construct(AbsensiRepository $absensiRepository){

        $this->absensiRepository = $absensiRepository;

    }

    public function absenMasuk($request){

        $dateTime = Carbon::now();
        $late = new Carbon('08:15:00');
        $endAbsen = new Carbon('17:00:00');
        $data_absen = $this->absensiRepository->dataAbsenMasuk($dateTime);

        $data['status'] = "";
        $data['jam_masuk'] = $dateTime->toTimeString();
        $data['jam_pulang'] = null;
        $data['jenis_absen'] = $request['jenis_absen'];
        $data['koordinat'] = $request['koordinat'];


        if(empty($data_absen)){

            if($dateTime->toTimeString() > $late->toTimeString()){
                $data['status'] = 'TERLAMBAT';
            }else{
                $data['status'] = 'HADIR';
            }

        }else{
            throw new HttpResponseException(response()->json([
                'message'   => 'Anda Telah Melakukan Absen Hari Ini',
            ],500));
        }

        if($dateTime <= $endAbsen){

        return  $this->absensiRepository->absenMasuk($data,$dateTime);

        }else{
            throw new HttpResponseException(response()->json([
                'message'   => 'Masa Absen Telah Berakhir',
            ],500));
        }

    }


    public function absenPulang(){

        $dateTime = Carbon::now();
        $data_absen = $this->absensiRepository->dataAbsenPulang($dateTime);
        $data['jam_pulang'] = $dateTime->toTimeString();

        if(!empty($data_absen) && ($data_absen->status=='HADIR' || $data_absen->status =='TERLAMBAT')){

                return  $this->absensiRepository->absenPulang($data,$dateTime);

        }else if(!empty($data_absen) && ($data_absen->status=='IZIN' || $data_absen->status =='TIDAK HADIR')){

            throw new HttpResponseException(response()->json([
                'message'   => 'Anda Telah Melakukan Absen Hari Ini',
            ],500));

        }else{

            throw new HttpResponseException(response()->json([
                'message'   => 'Anda Belum Melakukan Absen Datang Hari Ini',
            ],500));

        }

    }


    public function cekAbsen(){
        $dateTime = Carbon::now()->toDateString();
        $users = $this->absensiRepository->dataUser();
        foreach($users as $user){
            $userAbsen = $this->absensiRepository->getUserNotAbsen($user->id,$dateTime);
            if(empty($userAbsen)){
                $this->absensiRepository->insertAbsenAlfa($user->id,$dateTime);
            }
        }
    }

}
