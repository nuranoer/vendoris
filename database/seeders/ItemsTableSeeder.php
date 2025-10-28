<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['kode_item' => 'IT01', 'nama_item' => 'Item 1'],
            ['kode_item' => 'IT02', 'nama_item' => 'Item 2'],
            ['kode_item' => 'IT03', 'nama_item' => 'Item 3'],
        ];

        foreach ($rows as $r) {
            Item::updateOrCreate(['kode_item' => $r['kode_item']], $r);
        }
    }
}
