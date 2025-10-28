<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Item extends Model {
  use SoftDeletes;
  protected $fillable=['kode_item','nama_item'];
  public function vendors(){ return $this->belongsToMany(Vendor::class, 'vendor_items')->withPivot('current_price')->withTimestamps(); }
}
