<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSimpanan extends Model
{
    public $timestamps = true;
    use HasFactory;
    protected $table = 'jenis_simpanan';
    protected $guarded = [];
}
