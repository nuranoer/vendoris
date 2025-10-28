<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class VendorItemPriceRequest extends FormRequest {
  public function authorize(): bool { return true; }
  public function rules(): array {
    return [
      'vendor_id' => ['required','exists:vendors,id'],
      'item_id'   => ['required','exists:items,id'],
      'price'     => ['required','numeric','min:0'],
      'effective_date' => ['required','date'],
    ];
  }
}