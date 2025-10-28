<?php

// app/Http/Controllers/Api/ItemController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
  public function index(){
    return response()->json(['status'=>true,'data'=>Item::orderBy('id')->paginate(10)]);
  }
  public function store(ItemRequest $r){
    $row = Item::create($r->validated());
    return response()->json(['status'=>true,'message'=>'created','data'=>$row],201);
  }
  public function show(Item $item){
    return response()->json(['status'=>true,'data'=>$item]);
  }
  public function update(ItemRequest $r, Item $item){
    $item->update($r->validated());
    return response()->json(['status'=>true,'message'=>'updated','data'=>$item]);
  }
  public function destroy(Item $item){
    $item->delete();
    return response()->json(['status'=>true,'message'=>'deleted']);
  }
}
