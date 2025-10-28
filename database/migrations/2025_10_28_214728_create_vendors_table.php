<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('vendors', function (Blueprint $t) {
      $t->id();
      $t->string('kode_vendor', 20)->unique();
      $t->string('nama_vendor', 150);
      $t->timestamps();
      $t->softDeletes();
    });
  }

  public function down(): void {
    Schema::dropIfExists('vendors');
  }
};
