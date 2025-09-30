<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'sku'            => ['required','string','max:50', Rule::unique('products','sku')->ignore($this->product)],
            'name'           => ['required','string','max:150'],
            'category'       => ['nullable','string','max:100'],
            'unit'           => ['required','string','max:20'],
            'cost_price'     => ['required','numeric','min:0'],
            'sell_price'     => ['required','numeric','min:0'],
            'reorder_point'  => ['required','integer','min:0'],
        ];
    }
}
