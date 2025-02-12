<?php

namespace App\Http\Controllers;

use App\Repositories\Provider\ProviderRepository;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $providerRepository;
    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }
    public function index()
    {
        $providers = $this->providerRepository->getAllData();
        return view('provider.index', compact('providers'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bkph_id' => 'required|exists:bkphs,id',
            'service_id' => 'required|exists:services,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ], [
            'service_id.required' => 'Service is required',
            'service_id.exists' => 'Service is not exists',
            'nama.required' => 'Nama is required',
            'alamat.required' => 'Alamat is required',
            'no_telp.required' => 'No Telp is required',
            'no_telp.max' => 'No Telp must be less than 255 characters',
            'nama.max' => 'Nama must be less than 255 characters',
            'alamat.max' => 'Alamat must be less than 255 characters',
        ]);
        try {
            $this->providerRepository->storeData($validated);
            return redirect()->route('provider.index')->with('success', 'Provider created successfully');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return redirect()->route('provider.index')->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'bkph_id' => 'required|exists:bkphs,id',
            'service_id' => 'required|exists:services,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
        ], [
            'service_id.required' => 'Service is required',
            'service_id.exists' => 'Service is not exists',
            'nama.required' => 'Nama is required',
            'alamat.required' => 'Alamat is required',
            'no_telp.required' => 'No Telp is required',
            'no_telp.max' => 'No Telp must be less than 255 characters',
            'nama.max' => 'Nama must be less than 255 characters',
            'alamat.max' => 'Alamat must be less than 255 characters',
        ]);
        try {
            $this->providerRepository->updateData($validated, $id);
            return redirect()->route('provider.index')->with('success', 'Provider updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('provider.index')->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $this->providerRepository->deleteData($id);
            return response()->json(['success' => true, 'message' => 'Provider deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
