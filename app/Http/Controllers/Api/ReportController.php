<?php

// app/Http/Controllers/Api/ReportController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  // 1) vendor -> item list
  public function vendorItems(){
    $rows = DB::table('vendors as v')
      ->select('v.id as id_vendor','v.kode_vendor','v.nama_vendor')
      ->orderBy('v.id')
      ->get()
      ->map(function($v){
        $items = DB::table('vendor_items as vi')
          ->join('items as i','i.id','=','vi.item_id')
          ->where('vi.vendor_id',$v->id_vendor)
          ->select('i.id as id_item','i.kode_item','i.nama_item')
          ->orderBy('i.id')
          ->get();
        return [
          'id_vendor'   => $v->id_vendor,
          'kode_vendor' => $v->kode_vendor,
          'nama_vendor' => $v->nama_vendor,
          'item'        => $items,
        ];
      });

    return response()->json(['status'=>true,'message'=>'data ditemukan','data'=>$rows]);
  }

    // 2) ranking vendor by jumlah transaksi
  public function vendorRankByTransactions(){
    $rows = DB::table('vendors as v')
      ->leftJoin('transactions as t','t.vendor_id','=','v.id')
      ->select('v.id as id_vendor','v.kode_vendor','v.nama_vendor', DB::raw('COUNT(t.id) as jumlah_transaksi'))
      ->groupBy('v.id','v.kode_vendor','v.nama_vendor')
      ->orderByDesc('jumlah_transaksi')
      ->get()
      ->map(function($r){
        $r->jumlah_transaksi = (float)$r->jumlah_transaksi; // untuk meniru format float di contoh
        return $r;
      });

    return response()->json(['status'=>true,'message'=>'data ditemukan','data'=>$rows]);
  }

    // 3) rate up/down berdasarkan 2 price history terbaru
  public function vendorItemPriceChange()
  {
    // Ambil 2 histori terakhir per vendor-item
    $latestTwo = DB::select("
      WITH ranked AS (
        SELECT
          ph.vendor_id,
          ph.item_id,
          ph.price,
          ph.effective_date,
          ROW_NUMBER() OVER (PARTITION BY ph.vendor_id, ph.item_id ORDER BY ph.effective_date DESC) AS rn
        FROM price_histories ph
      )
      SELECT * FROM ranked WHERE rn <= 2
    ");

    // Kelompokkan by vendor -> item, hitung selisih, rate, status
    $grouped = [];
    foreach ($latestTwo as $r) {
      $key = $r->vendor_id.'-'.$r->item_id;
      $grouped[$key][] = $r;
    }

    // map vendor => list items (dengan meta item)
    $vendors = DB::table('vendors')->select('id','kode_vendor','nama_vendor')->get()->keyBy('id');
    $items   = DB::table('items')->select('id','kode_item','nama_item')->get()->keyBy('id');

    $byVendor = [];
    foreach ($grouped as $key => $rows) {
      // urutkan rn ASC (rn=1 terbaru, rn=2 sebelumnya)
      usort($rows, fn($a,$b)=>$a->rn <=> $b->rn);
      $latest   = $rows[0] ?? null; // rn=1
      $previous = $rows[1] ?? null; // rn=2

      if(!$latest || !$previous) continue;

      $selisih = (float)$latest->price - (float)$previous->price;
      $rate = $previous->price == 0 ? 0.0 : round(($selisih / (float)$previous->price) * 100, 2);
      $status = $selisih < 0 ? 'down' : ($selisih > 0 ? 'up' : 'stable');

      $v = $vendors[$latest->vendor_id] ?? null;
      $i = $items[$latest->item_id] ?? null;
      if(!$v || !$i) continue;

      $byVendor[$v->id]['header'] = [
        'id_vendor'   => $v->id,
        'kode_vendor' => $v->kode_vendor,
        'nama_vendor' => $v->nama_vendor,
      ];

      $byVendor[$v->id]['items'][] = [
        'id_item'         => $i->id,
        'kode_item'       => $i->kode_item,
        'nama_item'       => $i->nama_item,
        'harga_sebelum'   => (float)$previous->price,
        'harga_sekarang'  => (float)$latest->price,
        'selisih'         => abs((float)$selisih),
        'rate'            => round(abs($rate), 2),
        'status'          => $status,
      ];
    }

    // susun sesuai contoh
    $data = [];
    foreach ($byVendor as $v) {
      $data[] = array_merge($v['header'], ['item'=>$v['items'] ?? []]);
    }

    return response()->json(['status'=>true,'message'=>'data ditemukan','data'=>$data]);
  }


}