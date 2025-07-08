<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemilik = User::create([
            'name' => 'pemilik',
            'email' => 'pemilik@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('11111111'),
            'remember_token' => Str::random(10),

        ]);

        $pemilik->assignRole('pemilik');


        $manajer = User::create([
            'name' => 'manajer',
            'email' => 'manajer@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('11111111'),
            'remember_token' => Str::random(10),

        ]);

        $manajer->assignRole('manajer');
    }
}
// 2314101098