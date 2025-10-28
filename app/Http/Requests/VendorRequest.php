<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest {
  public function authorize(): bool { return true; }
  public function rules(): array {
    $id = $this->route('vendor')?->id;
    return [
      'kode_vendor' => ['required','max:20','unique:vendors,kode_vendor,'.($id ?? 'null')],
      'nama_vendor' => ['required','max:150'],
    ];
  }
}
