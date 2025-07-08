<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabangtoko extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_cabang',
        'alamat_cabang',
        'id'
    ];
    public function pegawais()
    {
        return $this->belongsToMany(User::class, 'pegawaitoko');
    }
}
