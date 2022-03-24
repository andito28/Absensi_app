<?php
namespace App\Services;
use App\Repositories\LaporanKunjunganRepository;
use Carbon\Carbon;

class LaporanKunjunganService{

    protected $laporanKunjunganRepository;

    public function __construct(LaporanKunjunganRepository $laporanKunjunganRepository){

        $this->laporanKunjunganRepository = $laporanKunjunganRepository;

    }

    public function laporan($data){
        $date = Carbon::now();
        return $this->laporanKunjunganRepository->insertLaporan($data,$date);
    }
}
