<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    use HasFactory;

    protected $fillable = ['jurnal_id', 'akun_id', 'debit', 'kredit'];

    public function jurnal()
    {
        return $this->belongsTo(JurnalUmum::class, 'jurnal_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'akun_id');
    }
    public function akun()
    {
        return $this->belongsTo(Account::class, 'akun_id');
    }
}
