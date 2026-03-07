<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'wali_id',
    ];


    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
