<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\VendorItem;

class VendorItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            ['V01', 'IT01', 10000],
            ['V01', 'IT02', 27000],
            ['V02', 'IT03', 15000],
        ];

        foreach ($map as [$kodeVendor, $kodeItem, $currentPrice]) {
            $vendor = Vendor::where('kode_vendor', $kodeVendor)->first();
            $item   = Item::where('kode_item', $kodeItem)->first();

            if ($vendor && $item) {
                VendorItem::updateOrCreate(
                    ['vendor_id' => $vendor->id, 'item_id' => $item->id],
                    ['current_price' => $currentPrice]
                );
            }
        }
    }
}
