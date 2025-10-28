<?php

// app/Http/Controllers/Api/VendorItemController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorItemPriceRequest;
use App\Models\VendorItem;
use App\Models\PriceHistory;
use Illuminate\Http\Request;

class VendorItemController extends Controller
{
  // set/attach item ke vendor + set current price
  public function attach(Request $r){
    $data = $r->validate([
      'vendor_id'=>['required','exists:vendors,id'],
      'item_id'  =>['required','exists:items,id'],
      'current_price'=>['nullable','numeric','min:0'],
    ]);

    $vi = VendorItem::updateOrCreate(
      ['vendor_id'=>$data['vendor_id'],'item_id'=>$data['item_id']],
      ['current_price'=>$data['current_price'] ?? null]
    );

    return response()->json(['status'=>true,'message'=>'attached','data'=>$vi]);
  }

  // tambah histori harga
  public function addPriceHistory(VendorItemPriceRequest $r){
    $ph = PriceHistory::create($r->validated());
    // optional: update current price jika effective_date terbaru
    return response()->json(['status'=>true,'message'=>'price history added','data'=>$ph],201);
  }
}
