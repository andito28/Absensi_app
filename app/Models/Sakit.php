<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sakit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id','waktu','ket'];

    public function User(){

        return $this->belongsTo(User::class);

    }
}
