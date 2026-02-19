<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Siswa::create([
      'nama' => 'hikmal',
      'kelas_id' => Kelas::first()->id,
      'no_hp_orang_tua' => '0895366123060',
    ]);
  }
}
