<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJasaRequest extends FormRequest
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
            // Input data Wood secara langsung
            'jenis_kayu' => ['required', 'string', 'max:255'],
            'volume_m3' => ['required', 'integer', 'min:1'],
            'berat' => ['required', 'integer', 'min:1'],
            'panjang' => ['required', 'integer', 'min:1'],

            'customer_id' => ['required', 'exists:customers,id'], // Harus ada di tabel customers
            'provider_id' => ['required', 'exists:providers,id'], // Harus ada di tabel providers
            'tgl_pesanan' => ['required', 'date'],
            'tgl_kirim' => ['required', 'date', 'after_or_equal:tgl_pesanan'], // Tidak boleh sebelum tgl_pesanan
            'lokasi_pengambilan' => ['required', 'string', 'max:500'],
            'lokasi_pengantaran' => ['required', 'string', 'max:500'],
            'jenis_pengiriman' => ['required', Rule::in(['Per M3', 'Per Angkutan'])],
        ];
    }
    /**
     * Kustomisasi pesan error.
     */
    public function messages(): array
    {
        return [
            // Pesan error untuk data Wood
            'jenis_kayu.required' => 'Jenis kayu harus diisi.',
            'jenis_kayu.max' => 'Jenis kayu tidak boleh lebih dari 255 karakter.',
            'volume_m3.required' => 'Volume M3 harus diisi.',
            'volume_m3.integer' => 'Volume M3 harus berupa angka.',
            'volume_m3.min' => 'Volume M3 harus minimal 1.',
            'berat.required' => 'Berat kayu harus diisi.',
            'berat.integer' => 'Berat kayu harus berupa angka.',
            'berat.min' => 'Berat kayu harus minimal 1.',
            'panjang.required' => 'Panjang kayu harus diisi.',
            'panjang.integer' => 'Panjang kayu harus berupa angka.',
            'panjang.min' => 'Panjang kayu harus minimal 1.',

            'customer_id.required' => 'Pelanggan harus dipilih.',
            'customer_id.exists' => 'Pelanggan tidak valid.',
            'provider_id.required' => 'Penyedia jasa harus dipilih.',
            'provider_id.exists' => 'Penyedia jasa tidak valid.',
            'tgl_pesanan.required' => 'Tanggal pesanan harus diisi.',
            'tgl_pesanan.date' => 'Format tanggal pesanan tidak valid.',
            'tgl_kirim.required' => 'Tanggal kirim harus diisi.',
            'tgl_kirim.date' => 'Format tanggal kirim tidak valid.',
            'tgl_kirim.after_or_equal' => 'Tanggal kirim tidak boleh sebelum tanggal pesanan.',
            'lokasi_pengambilan.required' => 'Lokasi pengambilan harus diisi.',
            'lokasi_pengambilan.max' => 'Lokasi pengambilan maksimal 500 karakter.',
            'lokasi_pengantaran.required' => 'Lokasi pengantaran harus diisi.',
            'lokasi_pengantaran.max' => 'Lokasi pengantaran maksimal 500 karakter.',
            'jenis_pengiriman.required' => 'Jenis pengiriman harus dipilih.',
            'jenis_pengiriman.in' => 'Jenis pengiriman tidak valid.',
        ];
    }
}
