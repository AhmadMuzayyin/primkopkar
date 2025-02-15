<?php

namespace App\Http\Controllers;

use App\Repositories\Service\ServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }
    public function index()
    {
        $services = $this->serviceRepository->getAll();
        return view('service.index', compact('services'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|regex:/^[A-Za-z\s]+$/',
            'deskripsi' => 'required',
            'harga_per_m3' => 'required|numeric',
            'harga_per_angkutan' => 'required|numeric',
            'volume_max' => 'required|numeric',
            'persentase_komisi' => 'required|numeric',
        ], [
            'nama.regex' => 'Nama Layanan harus berupa huruf',
            'nama.required' => 'Nama Layanan harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'harga_per_m3.required' => 'Harga Per M3 harus diisi',
            'harga_per_angkutan.required' => 'Harga Per Angkutan harus diisi',
            'volume_max.required' => 'Volume Maksimal harus diisi',
            'persentase_komisi.required' => 'Persentase Komisi harus diisi',
            'harga_per_m3.numeric' => 'Harga Per M3 harus berupa angka',
            'harga_per_angkutan.numeric' => 'Harga Per Angkutan harus berupa angka',
            'volume_max.numeric' => 'Volume Maksimal harus berupa angka',
            'persentase_komisi.numeric' => 'Persentase Komisi harus berupa angka',
        ]);
        try {
            $this->serviceRepository->storeData($validated);
            return redirect()->route('service.index')->with('success', 'Service created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|regex:/^[A-Za-z\s]+$/',
            'deskripsi' => 'required',
            'harga_per_m3' => 'required|numeric',
            'harga_per_angkutan' => 'required|numeric',
            'volume_max' => 'required|numeric',
            'persentase_komisi' => 'required|numeric',
        ], [
            'nama.regex' => 'Nama Layanan harus berupa huruf',
            'nama.required' => 'Nama Layanan harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'harga_per_m3.required' => 'Harga Per M3 harus diisi',
            'harga_per_angkutan.required' => 'Harga Per Angkutan harus diisi',
            'volume_max.required' => 'Volume Maksimal harus diisi',
            'persentase_komisi.required' => 'Persentase Komisi harus diisi',
            'harga_per_m3.numeric' => 'Harga Per M3 harus berupa angka',
            'harga_per_angkutan.numeric' => 'Harga Per Angkutan harus berupa angka',
            'volume_max.numeric' => 'Volume Maksimal harus berupa angka',
            'persentase_komisi.numeric' => 'Persentase Komisi harus berupa angka',
        ]);
        try {
            $this->serviceRepository->updateData($validated, $id);
            return redirect()->back()->with('success', 'Layanan berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $this->serviceRepository->deleteData($id);
            return response()->json(['success' => true, 'message' => 'Layanan berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
