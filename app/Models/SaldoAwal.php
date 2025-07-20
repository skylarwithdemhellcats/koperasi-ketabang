<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoAwal extends Model
{
    protected $table = 'saldo_awal';

    protected $fillable = ['akun_id', 'bulan', 'tahun', 'jumlah'];

    public function akun()
    {
        return $this->belongsTo(Account::class, 'akun_id');
    }
}
