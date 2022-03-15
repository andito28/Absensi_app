<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id','jenis_izin','waktu_mulai','waktu_selesai','ket'];

    public function User(){

        return $this->belongsTo(User::class);

    }
}
