<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PriceHistory extends Model {
  protected $fillable=['vendor_id','item_id','price','effective_date'];
  public function vendor(){ return $this->belongsTo(Vendor::class); }
  public function item(){ return $this->belongsTo(Item::class); }
}
