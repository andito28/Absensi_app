<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'nama','jenis_kelamin','posisi','hp','password','role',
    ];

    public function Absen(){
        return $this->hasMany(Absen::class);
    }

    public function Sakit(){
        return $this->hasMany(Sakit::class);
    }

    public function Izin(){
        return $this->hasMany(Izin::class);
    }

    public function LaporanHarian(){
        return $this->hasMany(LaporanHarian::class);
    }

    public function LaporanKunjungan(){
        return $this->hasMany(LaporanKunjungan::class);
    }
}
