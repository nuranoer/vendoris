<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\VendorItemController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ReportController;

Route::get('ping', fn() => response()->json(['pong' => true]));

Route::prefix('auth')->group(function(){
  Route::post('register',[AuthController::class,'register']);
  Route::post('login',[AuthController::class,'login']);
  Route::middleware('auth:api')->group(function(){
    Route::get('me',[AuthController::class,'me']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('logout',[AuthController::class,'logout']);
  });
});

// semua di bawah butuh token JWT
Route::middleware('auth:api')->group(function(){

  // CRUD Vendors
  Route::apiResource('vendors', VendorController::class);

  // CRUD Items
  Route::apiResource('items', ItemController::class);

  // Relasi vendor-item & price history
  Route::post('vendor-items/attach', [VendorItemController::class, 'attach']);
  Route::post('vendor-items/price-history', [VendorItemController::class, 'addPriceHistory']);

  // Transaksi
  Route::get('transactions', [TransactionController::class,'index']);
  Route::post('transactions', [TransactionController::class,'store']);
  Route::get('transactions/{transaction}', [TransactionController::class,'show']);

  // Reports
  Route::get('reports/vendor-items', [ReportController::class,'vendorItems']);
  Route::get('reports/vendor-rank', [ReportController::class,'vendorRankByTransactions']);
  Route::get('reports/price-change', [ReportController::class,'vendorItemPriceChange']);
});
