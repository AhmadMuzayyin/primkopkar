<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required',],
            'name' => ['required', 'string', 'min:5'],
            'price' => ['required', 'numeric', 'min:1000'],
            'purchase_price' => ['required', 'numeric', 'min:1000'],
            'margin' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'shu' => ['required', 'numeric', 'min:1'],
            'price_credit' => ['required', 'numeric', 'min:1000'],
            'description' => ['nullable']
        ];
    }
}
