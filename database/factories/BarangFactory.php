<?php

namespace Database\Factories;
use App\Models\Cabangtoko;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaBarangIndonesia = [
            'Sabun Mandi', 'Teh Celup', 'Minyak Goreng', 'Gula Pasir', 'Kopi Bubuk',
            'Beras Putih', 'Deterjen Bubuk', 'Mie Instan', 'Tepung Terigu', 'Susu Kental Manis',
            'Minuman Soda', 'Biskuit Roti', 'Mentega', 'Cokelat Batangan', 'Sarden Kalengan',
            'Kecap Manis', 'Saos Sambal', 'Kerupuk Udang', 'Pasta Gigi', 'Tisu Dapur'
        ];

        return [
            'nama_barang' => $this->faker->randomElement($namaBarangIndonesia),
            'harga_barang' => $this->faker->numberBetween(10000, 500000),
            'kode_barang' => strtoupper($this->faker->bothify('BRG-###??')),
            'stok_barang' => $this->faker->numberBetween(1, 200),
            'kadarluarsa_barang' => $this->faker->date('Y-m-d', '+1 year'),
            'cabangtoko_id' => 1,
        ];
    }
}
