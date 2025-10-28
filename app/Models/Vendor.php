<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model {
  use SoftDeletes;
  protected $fillable = ['kode_vendor','nama_vendor'];
  public function items(){ return $this->belongsToMany(Item::class, 'vendor_items')->withPivot('current_price')->withTimestamps(); }
  public function transactions(){ return $this->hasMany(Transaction::class); }
}
