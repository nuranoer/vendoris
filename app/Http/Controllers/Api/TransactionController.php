<?php

// app/Http/Controllers/Api/TransactionController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  public function index(){
    $rows = Transaction::with(['vendor','details.item'])->orderByDesc('id')->paginate(10);
    return response()->json(['status'=>true,'data'=>$rows]);
  }

  public function store(TransactionRequest $r){
    return DB::transaction(function() use ($r){
      $data = $r->validated();
      $trx = Transaction::create([
        'vendor_id'=>$data['vendor_id'],
        'kode_transaksi'=>$data['kode_transaksi'],
        'tanggal_transaksi'=>$data['tanggal_transaksi'],
      ]);

      foreach($data['items'] as $it){
        TransactionItem::create([
          'transaction_id'=>$trx->id,
          'item_id'=>$it['item_id'],
          'qty'=>$it['qty'],
          'harga_satuan'=>$it['harga_satuan'],
          'subtotal'=>$it['qty'] * $it['harga_satuan'],
        ]);
      }

      return response()->json(['status'=>true,'message'=>'created','data'=>$trx->load('details.item')],201);
    });
  }

  public function show(Transaction $transaction){
    return response()->json(['status'=>true,'data'=>$transaction->load(['vendor','details.item'])]);
  }

  // update & delete bisa ditambahkan serupa (validasi berbeda)
}

