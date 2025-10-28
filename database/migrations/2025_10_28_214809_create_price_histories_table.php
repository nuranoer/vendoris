<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('price_histories', function (Blueprint $t) {
      $t->id();
      $t->foreignId('vendor_id')->constrained('vendors');
      $t->foreignId('item_id')->constrained('items');
      $t->decimal('price', 14, 2);
      $t->date('effective_date');
      $t->timestamps();

      $t->unique(['vendor_id','item_id','effective_date']);
      $t->index(['vendor_id']);
      $t->index(['item_id']);
      $t->index(['effective_date']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('price_histories');
  }
};
