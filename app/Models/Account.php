<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_akun',
        'nama_akun',
        'tipe',
        'kategori',
        'status',
        'deskripsi',
    ];

    public function jurnalDetails()
    {
        return $this->hasMany(JurnalDetail::class, 'akun_id');
    }

    public function saldoAwal()
    {
        return $this->hasMany(SaldoAwal::class, 'akun_id');
    }
}
