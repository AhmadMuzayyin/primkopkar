<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9]+$/',
                'unique:members,phone,' . $this->route('members') . ',id'
            ],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
