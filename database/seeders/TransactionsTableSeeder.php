<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Transaction;

class TransactionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // kode_vendor, kode_transaksi, tanggal
            ['V01','TRX-001','2025-10-01'],
            ['V01','TRX-002','2025-10-05'],
            ['V02','TRX-003','2025-10-02'],
        ];

        foreach ($rows as [$kodeVendor, $kodeTrx, $tgl]) {
            $vendor = Vendor::where('kode_vendor', $kodeVendor)->first();

            if ($vendor) {
                Transaction::updateOrCreate(
                    ['kode_transaksi' => $kodeTrx],
                    ['vendor_id' => $vendor->id, 'tanggal_transaksi' => $tgl]
                );
            }
        }
    }
}
