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

        function haversineGreatCircleDistance(
            $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo){
            $earthRadius = 6371000;
            // convert from degrees to radians
            $latFrom = deg2rad($latitudeFrom);
            $lonFrom = deg2rad($longitudeFrom);
            $latTo = deg2rad($latitudeTo);
            $lonTo = deg2rad($longitudeTo);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
            return $angle * $earthRadius;
        }


        function insertAbsen($request){
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


    public function absenMasuk($request){

        if($request->jenis_absen == 'wfo'){
            $lokasiKantor = $this->absensiRepository->getLokasiKantor();

            $koordinatUser = explode('_',$request->koordinat);
            $koordinatKantor = explode('_',$lokasiKantor->titik_koordinat);

            $radius = 30;
            if( $this->haversineGreatCircleDistance($koordinatUser[0],$koordinatUser[1],$koordinatKantor[0],$koordinatKantor[1]) <= $radius){

                return $this->insertAbsen($request);

            }else{
                throw new HttpResponseException(response()->json([
                    'message'   => 'Maaf Anda berada Diluar Radius Kantor'
                ],500));
            }
        }else{

            return $this->insertAbsen($request);

        }

    }


    public function absenPulang($request){

        $dateTime = Carbon::now();
        $data_absen = $this->absensiRepository->dataAbsenPulang($dateTime);
        $data['jam_pulang'] = $dateTime->toTimeString();
        $waktu_pulang = new Carbon('17:00:00');

        if($dateTime->toTimeString() <= $waktu_pulang){
            throw new HttpResponseException(response()->json([
                'message'   => 'Belum Bisa Melakukan Absen Pulang',
            ],500));
        }

        if(!empty($data_absen) && ($data_absen->status=='HADIR' || $data_absen->status =='TERLAMBAT')){

            if($request->jenis_absen == 'wfo'){
                $lokasiKantor = $this->absensiRepository->getLokasiKantor();

                $koordinatUser = explode('_',$request->koordinat);
                $koordinatKantor = explode('_',$lokasiKantor->titik_koordinat);

                $radius = 30;
                if( $this->haversineGreatCircleDistance($koordinatUser[0],$koordinatUser[1],$koordinatKantor[0],$koordinatKantor[1]) <= $radius){

                    return  $this->absensiRepository->absenPulang($data,$dateTime);

                }else{
                    throw new HttpResponseException(response()->json([
                        'message'   => 'Maaf Anda berada Diluar Radius Kantor'
                    ],500));
                }
            }else{

                return  $this->absensiRepository->absenPulang($data,$dateTime);

            }

        }else if(!empty($data_absen) && ($data_absen->status=='IZIN' || $data_absen->status =='TIDAK HADIR' || $data_absen->status =='SAKIT')){

            throw new HttpResponseException(response()->json([
                'message'   => 'Anda Telah Melakukan Absen Hari Ini',
            ],500));

        }else{

            throw new HttpResponseException(response()->json([
                'message'   => 'Anda Belum Melakukan Absen Datang Hari Ini',
            ],500));

        }

    }


    public function getAbsen(){
        $dateTime = Carbon::now();
        return $this->absensiRepository->getAbsensi($dateTime);
    }


    public function cekAbsenMasuk(){

        $dateTime = Carbon::now()->toDateString();
        $users = $this->absensiRepository->dataUser();
        foreach($users as $user){
            $userAbsen = $this->absensiRepository->getUserNotAbsen($user->id,$dateTime);
            if(empty($userAbsen)){
                 //testing
            $hari_ini = date("Ymd");

            //default time zone
            date_default_timezone_set("Asia/Makassar");

                $array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/Json-Indonesia-holidays/master/calendar.json"),true);

                //check tanggal merah berdasarkan libur nasional
                if(isset($array[$hari_ini]))
            :		$dataStatus['status'] = 'LIBUR';

                //check tanggal merah berdasarkan hari minggu
                elseif(
            date("D",strtotime($hari_ini))==="Sun")
            :		$dataStatus['status'] = 'LIBUR';

                //bukan tanggal merah
                else
                    :$dataStatus['status'] = 'TIDAK HADIR';
                endif;

                $this->absensiRepository->insertAbsenAlfa($user->id,$dateTime,$dataStatus);
            }
        }
    }

    public function cekAbsenPulang(){

        $dateTime = Carbon::now()->toDateString();
        $users = $this->absensiRepository->dataUser();

        foreach($users as $user){
            $userAbsen = $this->absensiRepository->getUserAbsen($user->id,$dateTime);
            if(!empty($userAbsen) && $userAbsen->jam_masuk != null && $userAbsen->jam_pulang == null){
                $this->absensiRepository->updateAbsenPulang($user->id,$userAbsen->tgl);
            }
        }

    }

}
