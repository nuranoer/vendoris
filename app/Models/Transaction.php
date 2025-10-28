<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Transaction extends Model {
  use SoftDeletes;
  protected $fillable=['vendor_id','kode_transaksi','tanggal_transaksi'];
  public function vendor(){ return $this->belongsTo(Vendor::class); }
  public function details(){ return $this->hasMany(TransactionItem::class); }
}
