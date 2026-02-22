<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a wali_kelas user for another class if not present
        if (! User::where('role', 'wali_kelas')->exists()) {
            User::create([
                'name' => 'Wali Kelas 2',
                'email' => 'wali2@gmail.com',
                'password' => Hash::make('wali123'),
                'role' => 'wali_kelas',
                'kelas_id' => null,
            ]);
        }
    }
}
