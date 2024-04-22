<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemagang extends Model
{
    use HasFactory;
    protected $table = "pemagang";

    protected $fillable = [
        'nama',
        'nik',
        'institusi'
    ];
}
