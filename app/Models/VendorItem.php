<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VendorItem extends Model {
  protected $fillable=['vendor_id','item_id','current_price'];
  public function vendor(){ return $this->belongsTo(Vendor::class); }
  public function item(){ return $this->belongsTo(Item::class); }
}