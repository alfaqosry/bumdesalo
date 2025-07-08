<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawaitoko extends Model
{
    use HasFactory;
    protected $table = "pegawaitoko"; 
    protected $fillable = [
        'user_id',
        'jabatan',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

}
