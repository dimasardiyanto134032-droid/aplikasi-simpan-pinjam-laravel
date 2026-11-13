<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_anggota',
        'nama',
        'nik',
        'no_hp',
        'alamat',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
