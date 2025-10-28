<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\PriceHistory;

class PriceHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // vendor, item, price, effective_date
            ['V01','IT01',15000,'2025-09-01'],
            ['V01','IT01',10000,'2025-10-01'],
            ['V01','IT02',25000,'2025-09-01'],
            ['V01','IT02',27000,'2025-10-01'],
            ['V02','IT03',15000,'2025-09-01'],
            ['V02','IT03',15000,'2025-10-01'],
        ];

        foreach ($rows as [$kodeVendor, $kodeItem, $price, $date]) {
            $vendor = Vendor::where('kode_vendor', $kodeVendor)->first();
            $item   = Item::where('kode_item', $kodeItem)->first();

            if ($vendor && $item) {
                PriceHistory::updateOrCreate(
                    ['vendor_id' => $vendor->id, 'item_id' => $item->id, 'effective_date' => $date],
                    ['price' => $price]
                );
            }
        }
    }
}
