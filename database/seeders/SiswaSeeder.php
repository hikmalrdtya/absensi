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
    $kelasIds = Kelas::pluck('id')->toArray();
    if (empty($kelasIds)) {
      // if no kelas exist, create a default one
      $k = Kelas::create(['nama_kelas' => 'X-A']);
      $kelasIds = [$k->id];
    }

    for ($i = 1; $i <= 20; $i++) {
      Siswa::create([
        'nama' => "Siswa {$i}",
        'kelas_id' => $kelasIds[array_rand($kelasIds)],
        'no_hp_orang_tua' => '081100000' . str_pad($i, 3, '0', STR_PAD_LEFT),
      ]);
    }
  }
}
