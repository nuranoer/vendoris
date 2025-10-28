<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // OPTIONAL: bersihkan data dulu (hati-hati di production!)
        // $this->truncateAll();

        $this->call([
            UsersTableSeeder::class,
            VendorsTableSeeder::class,
            ItemsTableSeeder::class,
            VendorItemsTableSeeder::class,
            PriceHistoriesTableSeeder::class,
            TransactionsTableSeeder::class,
            TransactionItemsTableSeeder::class,
        ]);
    }

    /** Optional helper untuk reset data lokal/dev */
    protected function truncateAll(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('transaction_items')->truncate();
        DB::table('transactions')->truncate();
        DB::table('price_histories')->truncate();
        DB::table('vendor_items')->truncate();
        DB::table('items')->truncate();
        DB::table('vendors')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
