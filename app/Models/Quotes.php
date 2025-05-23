<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $table = 'quotes';
    protected $fillable = ['text'];
    public $timestamps = false;
}
