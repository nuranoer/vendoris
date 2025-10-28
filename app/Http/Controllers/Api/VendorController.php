<?php

// app/Http/Controllers/Api/VendorController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Http\Requests\VendorRequest;

class VendorController extends Controller
{
  public function index(){
    return response()->json(['status'=>true,'data'=>Vendor::orderBy('id')->paginate(10)]);
  }
  public function store(VendorRequest $r){
    $row = Vendor::create($r->validated());
    return response()->json(['status'=>true,'message'=>'created','data'=>$row],201);
  }
  public function show(Vendor $vendor){
    return response()->json(['status'=>true,'data'=>$vendor]);
  }
  public function update(VendorRequest $r, Vendor $vendor){
    $vendor->update($r->validated());
    return response()->json(['status'=>true,'message'=>'updated','data'=>$vendor]);
  }
  public function destroy(Vendor $vendor){
    $vendor->delete();
    return response()->json(['status'=>true,'message'=>'deleted']);
  }
}
