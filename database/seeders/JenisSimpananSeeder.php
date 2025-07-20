<?php

namespace Database\Seeders;

use App\Models\JenisSimpanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSimpananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')->latest('id')->first();

        $data = [
            [
                'nama' => 'Simpanan Pokok',
                'deskripsi' => 'Syarat resmi jadi anggota koperasi',
                'created_by' => $user?->id ?? 1,
                'updated_by' => $user?->id ?? 1,
            ],
            [
                'nama' => 'Simpanan Wajib',
                'deskripsi' => 'Simpanan wajib setiap bulan',
                'created_by' => $user?->id ?? 1,
                'updated_by' => $user?->id ?? 1,
            ],
            [
                'nama' => 'Simpanan Sukarela',
                'deskripsi' => 'Simpanan Bebas kapan saja',
                'created_by' => $user?->id ?? 1,
                'updated_by' => $user?->id ?? 1,
            ],
        ];

        JenisSimpanan::insert($data);
    }
}
