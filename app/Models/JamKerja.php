<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    use HasFactory;
    protected $table = 'jam_kerja';
    protected $fillable = ['jam_masuk','jam_pulang'];
    public $timestamps = false;
}
