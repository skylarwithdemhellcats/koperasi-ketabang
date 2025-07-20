<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['kode_akun' => '111', 'nama_akun' => 'Kas', 'tipe' => 'Debit', 'kategori' => 'Aset'],
            ['kode_akun' => '112', 'nama_akun' => 'Bank', 'tipe' => 'Debit', 'kategori' => 'Aset'],
            ['kode_akun' => '113', 'nama_akun' => 'Piutang', 'tipe' => 'Debit', 'kategori' => 'Aset'],
            ['kode_akun' => '121', 'nama_akun' => 'Persediaan usaha toko', 'tipe' => 'Debit', 'kategori' => 'Aset'],

            ['kode_akun' => '211', 'nama_akun' => 'Simpanan Pokok', 'tipe' => 'Kredit', 'kategori' => 'Liabilitas'],

            ['kode_akun' => '212', 'nama_akun' => 'Simpanan Wajib', 'tipe' => 'Kredit', 'kategori' => 'Ekuitas'],
            ['kode_akun' => '213', 'nama_akun' => 'Simpanan Sukarela', 'tipe' => 'Kredit', 'kategori' => 'Ekuitas'],
            ['kode_akun' => '214', 'nama_akun' => 'Simpanan Insidental', 'tipe' => 'Kredit', 'kategori' => 'Ekuitas'],
            ['kode_akun' => '511', 'nama_akun' => 'Modal Koperasi', 'tipe' => 'Kredit', 'kategori' => 'Ekuitas'],

            ['kode_akun' => '311', 'nama_akun' => 'Pendapatan Bunga Pinjaman', 'tipe' => 'Kredit', 'kategori' => 'Pendapatan'],
            ['kode_akun' => '312', 'nama_akun' => 'Pendapatan Administrasi', 'tipe' => 'Kredit', 'kategori' => 'Pendapatan'],
            ['kode_akun' => '313', 'nama_akun' => 'Pendapatan Non Operasional', 'tipe' => 'Kredit', 'kategori' => 'Pendapatan'],
            ['kode_akun' => '314', 'nama_akun' => 'Pendapatan usaha toko', 'tipe' => 'Kredit', 'kategori' => 'Pendapatan'],

            ['kode_akun' => '411', 'nama_akun' => 'Beban Listrik, Air, dan Telepon', 'tipe' => 'Debit', 'kategori' => 'Beban'],
            ['kode_akun' => '412', 'nama_akun' => 'Beban Sewa Kantor', 'tipe' => 'Debit', 'kategori' => 'Beban'],
            ['kode_akun' => '413', 'nama_akun' => 'Beban Gaji', 'tipe' => 'Debit', 'kategori' => 'Beban'],
            ['kode_akun' => '414', 'nama_akun' => 'Beban Non Operasional', 'tipe' => 'Debit', 'kategori' => 'Beban'],
        ];

        foreach ($accounts as $account) {
            Account::updateOrCreate(
                ['kode_akun' => $account['kode_akun']], // Cek berdasarkan kode_akun
                $account // Jika tidak ada, buat baru; jika ada, update
            );
        }

    }
}
