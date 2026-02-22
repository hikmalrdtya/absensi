<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin account
        if (! User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]);
        }

        // create one wali_kelas linked to first kelas if exists
        if (Kelas::count() && ! User::where('role', 'wali_kelas')->exists()) {
            $wali = User::create([
                'name' => 'Wali Kelas',
                'email' => 'wali@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'petugas',
                'kelas_id' => Kelas::first()->id,
            ]);

            // set kelas.wali_id to link back to user
            $firstKelas = Kelas::first();
            if ($firstKelas) {
                $firstKelas->wali_id = $wali->id;
                $firstKelas->save();
            }
        }
    }
}
