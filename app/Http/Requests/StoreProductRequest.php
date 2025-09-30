<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'sku'            => ['required','string','max:50','unique:products,sku'],
            'name'           => ['required','string','max:150'],
            'category'       => ['nullable','string','max:100'],
            'unit'           => ['required','string','max:20'],
            'cost_price'     => ['required','numeric','min:0'],
            'sell_price'     => ['required','numeric','min:0'],
            'reorder_point'  => ['required','integer','min:0'],
        ];
    }
}
