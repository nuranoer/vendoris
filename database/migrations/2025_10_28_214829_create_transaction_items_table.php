<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('transaction_items', function (Blueprint $t) {
      $t->id();
      $t->foreignId('transaction_id')
        ->constrained('transactions')
        ->cascadeOnDelete();
      $t->foreignId('item_id')->constrained('items');
      $t->integer('qty');
      $t->decimal('harga_satuan', 14, 2);
      $t->decimal('subtotal', 14, 2);
      $t->timestamps();

      $t->index(['transaction_id']);
      $t->index(['item_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('transaction_items');
  }
};
