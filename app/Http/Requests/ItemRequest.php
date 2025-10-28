<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ItemRequest extends FormRequest {
  public function authorize(): bool { return true; }
  public function rules(): array {
    $id = $this->route('item')?->id;
    return [
      'kode_item' => ['required','max:20','unique:items,kode_item,'.($id ?? 'null')],
      'nama_item' => ['required','max:150'],
    ];
  }
}