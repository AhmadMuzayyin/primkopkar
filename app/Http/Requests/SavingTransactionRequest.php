<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavingTransactionRequest extends FormRequest
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
            'member_id' => ['required', 'exists:members,id'],
            'saving_category_id' => ['required', 'exists:saving_categories,id'],
            'nominal' => ['required', 'numeric'],
        ];
    }
}
