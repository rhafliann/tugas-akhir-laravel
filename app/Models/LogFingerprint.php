<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LogFingerprint extends Model {

  use HasFactory;

  protected $table = 'log_fingerprint';

  protected $fillable = [
    'cloud_id',
    'nik',
    'type',
    'scan_time',
    'original_data',
  ];

}