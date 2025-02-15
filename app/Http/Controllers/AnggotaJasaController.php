<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AnggotaJasaController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('anggota_jasa.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'alamat' => 'required|string',
            'telepon' => 'required|string|unique:customers,telepon',
        ], [
            'nama.regex' => 'Nama pelanggan hanya boleh berisi huruf dan spasi',
            'nama.required' => 'Nama pelanggan harus diisi',
            'alamat.required' => 'Alamat pelanggan harus diisi',
            'telepon.required' => 'Telepon pelanggan harus diisi',
            'telepon.unique' => 'Telepon pelanggan sudah terdaftar',
        ]);
        try {
            Customer::create($validated);
            return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'alamat' => 'required|string',
            'telepon' => 'required|string|unique:customers,telepon,' . $customer->id,
        ], [
            'nama.regex' => 'Nama pelanggan hanya boleh berisi huruf dan spasi',
            'nama.required' => 'Nama pelanggan harus diisi',
            'alamat.required' => 'Alamat pelanggan harus diisi',
            'telepon.required' => 'Telepon pelanggan harus diisi',
            'telepon.unique' => 'Telepon pelanggan sudah terdaftar',
        ]);
        try {
            $customer->update($validated);
            return redirect()->back()->with('success', 'Pelanggan berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Pelanggan berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
