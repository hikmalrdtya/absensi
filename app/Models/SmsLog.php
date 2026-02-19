<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
  protected $table = 'sms_logs';

  protected $fillable = [
    'siswa_id',
    'phone',
    'message',
    'status',
    'response',
    'error',
  ];

  public function siswa()
  {
    return $this->belongsTo(Siswa::class);
  }
}
