<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $kelas = [
      ['nama_kelas' => 'X-A'],
      ['nama_kelas' => 'X-B'],
      ['nama_kelas' => 'XI-A'],
    ];

    foreach ($kelas as $k) {
      Kelas::create($k);
    }
  }
}
