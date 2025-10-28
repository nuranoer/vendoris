<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('transactions', function (Blueprint $t) {
      $t->id();
      $t->foreignId('vendor_id')->constrained('vendors');
      $t->string('kode_transaksi', 30)->unique();
      $t->date('tanggal_transaksi');
      $t->timestamps();
      $t->softDeletes();

      $t->index(['vendor_id']);
      $t->index(['tanggal_transaksi']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('transactions');
  }
};
