<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'stok_barang',
        'harga_barang',
        'kadarluarsa_barang',
      

    ];

    public function bapenjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

}
