<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\TransactionItem;

class TransactionItemsTableSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // kode_transaksi, kode_item, qty, harga_satuan
            ['TRX-001','IT01',2,10000],
            ['TRX-002','IT02',1,27000],
            ['TRX-003','IT03',3,15000],
        ];

        foreach ($rows as [$kodeTrx, $kodeItem, $qty, $harga]) {
            $trx  = Transaction::where('kode_transaksi', $kodeTrx)->first();
            $item = Item::where('kode_item', $kodeItem)->first();

            if ($trx && $item) {
                TransactionItem::updateOrCreate(
                    [
                        'transaction_id' => $trx->id,
                        'item_id'        => $item->id,
                    ],
                    [
                        'qty'           => $qty,
                        'harga_satuan'  => $harga,
                        'subtotal'      => $qty * $harga,
                    ]
                );
            }
        }
    }
}
