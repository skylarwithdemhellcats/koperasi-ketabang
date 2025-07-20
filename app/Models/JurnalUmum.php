<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'keterangan', 'no_jurnal'];

    public function details()
    {
        return $this->hasMany(JurnalDetail::class, 'jurnal_id');
    }
}
