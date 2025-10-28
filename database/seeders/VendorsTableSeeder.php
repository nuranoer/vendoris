<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['kode_vendor' => 'V01', 'nama_vendor' => 'Vendor 1'],
            ['kode_vendor' => 'V02', 'nama_vendor' => 'Vendor 2'],
            ['kode_vendor' => 'V03', 'nama_vendor' => 'Vendor 3'],
        ];

        foreach ($rows as $r) {
            Vendor::updateOrCreate(['kode_vendor' => $r['kode_vendor']], $r);
        }
    }
}
