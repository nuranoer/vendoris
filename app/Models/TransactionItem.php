<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TransactionItem extends Model {
  protected $fillable=['transaction_id','item_id','qty','harga_satuan','subtotal'];
  public function transaction(){ return $this->belongsTo(Transaction::class); }
  public function item(){ return $this->belongsTo(Item::class); }
}
