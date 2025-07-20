<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
        'user-list',

        'role-list',
        'role-create',
        'role-edit',
        'role-delete',

        'nasabah-list',
        'nasabah-create',
        'nasabah-detail',
        'nasabah-edit',
        'nasabah-delete',

        'simpanan-list',
        'simpanan-create',
        'simpanan-edit',
        'simpanan-delete',
        'simpanan-detail',

        'penarikan-list',
        'penarikan-create',
        'penarikan-edit',
        'penarikan-delete',

        'pinjaman-list',
        'pinjaman-create',
        'pinjaman-edit',
        'pinjaman-delete',
        'pinjaman-detail',

        'angsuran-create',
        'angsuran-edit',
        'angsuran-delete',

        'laporan_list',
        'laporan_simpanan',
        'laporan_pinjaman',
        'laporan_angsuran',
        'laporan_penarikan',

        'approve_penarikan',
        'approve_pinjaman',
        'tolak_penarikan',
        'tolak_pinjaman',

        'akun-list',
        'akun-create',
        'akun-edit',
        'akun-delete',

        'saldo-awal-list',
        'saldo-awal-create',
        'saldo-awal-edit',
        'saldo-awal-delete',
    ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
