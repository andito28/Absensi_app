<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id','waktu','status','koordinat','jenis_absen'];

    public function User(){

        return $this->belongsTo(User::class);

    }
}
