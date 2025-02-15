<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'barcode' => ['required', 'string', 'min:10', 'max:13', Rule::unique('products')->ignore($this->product)],
            'category_id' => ['required'],
            'name' => ['required', 'string', 'min:5', 'regex:/^[A-Za-z\s]+$/'],
            'price' => ['required', 'numeric', 'min:1000'],
            'purchase_price' => ['required', 'numeric', 'min:1000'],
            'margin' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'shu' => ['required', 'numeric', 'min:1'],
            'price_credit' => ['required', 'numeric', 'min:1000', function ($attribute, $value, $fail) {
                if ($value <= request()->price) {
                    $fail('The ' . $attribute . ' must be greater than the price.');
                }
            }],
            'description' => ['nullable'],
        ];
    }
}
