<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'tgl_jatuh_tempo'        => 'required|numeric|in:1,7,14,30',
            'status'                 => 'required|in:Lunas,Belum Lunas',
        ];
    }
    /**
     * Pesan kesalahan untuk validasi.
     */
    public function messages(): array
    {
        return [
            'tgl_jatuh_tempo.required'        => 'Tanggal jatuh tempo wajib diisi.',
            'tgl_jatuh_tempo.date'            => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
            'tgl_jatuh_tempo.after_or_equal'  => 'Tanggal jatuh tempo tidak boleh lebih awal dari tanggal faktur.',
            'status.required'                 => 'Status pembayaran wajib dipilih.',
            'status.in'                       => 'Status harus "Lunas" atau "Belum Lunas".',
        ];
    }
}
