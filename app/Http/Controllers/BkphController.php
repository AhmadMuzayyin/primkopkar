<?php

namespace App\Http\Controllers;

use App\Models\Bkph;
use Illuminate\Http\Request;

class BkphController extends Controller
{
    public function index()
    {
        $bkphs = Bkph::all();
        return view('bkph.index', compact('bkphs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|numeric',
            'jenis_hutan' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama BKPH harus diisi',
            'wilayah.required' => 'Wilayah harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'kontak.required' => 'Kontak harus diisi',
            'jenis_hutan.required' => 'Jenis Hutan harus diisi',
        ]);
        try {
            Bkph::create($validated);
            return redirect()->back()->with('success', 'BKPH berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, Bkph $bkph)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|numeric',
            'jenis_hutan' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama BKPH harus diisi',
            'wilayah.required' => 'Wilayah harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'kontak.required' => 'Kontak harus diisi',
            'jenis_hutan.required' => 'Jenis Hutan harus diisi',
        ]);
        try {
            $bkph->update($validated);
            return redirect()->back()->with('success', 'BKPH berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Bkph $bkph)
    {
        try {
            $bkph->delete();
            return response()->json(['status' => 'success', 'message' => 'BKPH berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
