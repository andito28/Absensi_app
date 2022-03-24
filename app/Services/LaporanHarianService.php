<?php
namespace App\Services;
use App\Repositories\LaporanHarianRepository;
use Carbon\Carbon;

class LaporanHarianService{

protected $laporanHarianRepository;

public function __construct(LaporanHarianRepository $laporanHarianRepository){

    $this->laporanHarianRepository = $laporanHarianRepository;

}

public function laporan($data){
    $date = Carbon::now();
    return $this->laporanHarianRepository->insertLaporan($data,$date);
}

}
