<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cabangtoko;
use App\Models\Pegawaitoko;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'kepaladesa'

        ]);
      
        Role::create([
            'name' => 'pegawai'

        ]);
        Role::create([
            'name' => 'kasir'

        ]);
        $pemilik = User::create([
            'name' => 'Kepala Desa',
            'email' => 'kepaladesa@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('11111111'),
            'remember_token' => Str::random(10),

        ]);

        $pemilik->assignRole('kepaladesa');


       
    }

       
    }

