<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class TransactionRequest extends FormRequest {
  public function authorize(): bool { return true; }
  public function rules(): array {
    return [
      'vendor_id' => ['required','exists:vendors,id'],
      'kode_transaksi' => ['required','max:30','unique:transactions,kode_transaksi'],
      'tanggal_transaksi' => ['required','date'],
      'items' => ['required','array','min:1'],
      'items.*.item_id' => ['required','exists:items,id'],
      'items.*.qty' => ['required','integer','min:1'],
      'items.*.harga_satuan' => ['required','numeric','min:0'],
    ];
  }
}