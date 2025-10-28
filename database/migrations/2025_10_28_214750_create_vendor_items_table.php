<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('vendor_items', function (Blueprint $t) {
      $t->id();
      $t->foreignId('vendor_id')->constrained('vendors');
      $t->foreignId('item_id')->constrained('items');
      $t->decimal('current_price', 14, 2)->nullable();
      $t->timestamps();

      $t->unique(['vendor_id','item_id']);
      $t->index(['vendor_id']);
      $t->index(['item_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('vendor_items');
  }
};
