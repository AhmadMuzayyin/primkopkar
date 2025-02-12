<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\StoreJasaRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Provider;
use App\Models\Wood;
use App\Models\WoodShippingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiJasaController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $providers = Provider::all();
        $orders = WoodShippingOrder::where('status', 'pending')->get();
        return view('transaksi_jasa.index', compact('customers', 'providers', 'orders'));
    }
    public function store(StoreJasaRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction(); // Mulai transaksi database

        try {
            // Simpan data Wood terlebih dahulu
            $wood = Wood::create([
                'jenis_kayu' => $validated['jenis_kayu'],
                'volume_m3' => $validated['volume_m3'],
                'berat' => $validated['berat'],
                'panjang' => $validated['panjang'],
            ]);

            // Hitung total biaya berdasarkan jenis pengiriman
            $provider = Provider::findOrFail($validated['provider_id']);
            $volume = $validated['volume_m3'];
            $jenis_pengiriman = $validated['jenis_pengiriman'];
            $harga_per_m3 = $provider->service->harga_per_m3;
            $harga_per_angkutan = $provider->service->harga_per_angkutan;
            $kapasitas_angkutan = $provider->service->volume_max;

            if ($jenis_pengiriman == 'Per M3') {
                $total_biaya = $volume * $harga_per_m3;
            } else {
                $jumlah_angkutan = ceil($volume / $kapasitas_angkutan);
                $total_biaya = $jumlah_angkutan * $harga_per_angkutan;
            }

            WoodShippingOrder::create([
                'customer_id' => $validated['customer_id'],
                'provider_id' => $validated['provider_id'],
                'wood_id' => $wood->id,
                'tgl_pesanan' => $validated['tgl_pesanan'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'lokasi_pengambilan' => $validated['lokasi_pengambilan'],
                'lokasi_pengantaran' => $validated['lokasi_pengantaran'],
                'jenis_pengiriman' => $jenis_pengiriman,
                'harga_per_m3' => $harga_per_m3,
                'harga_per_angkutan' => $harga_per_angkutan,
                'kapasitas_angkutan_m3' => $kapasitas_angkutan,
                'total_biaya' => $total_biaya
            ]);


            DB::commit(); // Simpan semua perubahan jika tidak ada error

            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack(); // Batalkan semua perubahan jika ada error

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
    public function edit($id)
    {
        $order = WoodShippingOrder::with('customer', 'provider', 'wood')->findOrFail($id);
        return response()->json($order);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'provider_id' => 'required|exists:providers,id',
            'tgl_pesanan' => 'required|date',
            'tgl_kirim' => 'required|date',
            'jenis_kayu' => 'required|string',
            'volume_m3' => 'required|integer',
            'berat' => 'required|integer',
            'panjang' => 'required|integer',
            'lokasi_pengambilan' => 'required|string',
            'lokasi_pengantaran' => 'required|string',
            'jenis_pengiriman' => 'required|in:Per M3,Per Angkutan',
        ]);

        DB::beginTransaction();

        try {
            // Update data Wood
            $order = WoodShippingOrder::findOrFail($id);
            $wood = $order->wood;
            $wood->update([
                'jenis_kayu' => $validated['jenis_kayu'],
                'volume_m3' => $validated['volume_m3'],
                'berat' => $validated['berat'],
                'panjang' => $validated['panjang'],
            ]);

            // Update data WoodShippingOrder
            $order->update([
                'customer_id' => $validated['customer_id'],
                'provider_id' => $validated['provider_id'],
                'tgl_pesanan' => $validated['tgl_pesanan'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'lokasi_pengambilan' => $validated['lokasi_pengambilan'],
                'lokasi_pengantaran' => $validated['lokasi_pengantaran'],
                'jenis_pengiriman' => $validated['jenis_pengiriman'],
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil diperbarui!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            $order = WoodShippingOrder::findOrFail($id);
            $order->delete();

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil dihapus!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }
    public function proses(InvoiceRequest $request)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction(); // Mulai transaksi database

            $orders = WoodShippingOrder::where('status', 'pending')->get();
            $totalHarga = $orders->sum('total_biaya');

            // Hitung total harga berdasarkan jenis pengiriman
            foreach ($orders as $key => $order) {
                Invoice::create([
                    'wood_shipping_order_id' => $order->id,
                    'no_faktur' => 'INV/' . date('Ymd') . '/' . $order->id,
                    'tgl_faktur' => now(),
                    'total_pembayaran' => $totalHarga,
                    'tgl_jatuh_tempo' => $validated['status'] === 'Lunas' ? now() : now()->addDays($validated['tgl_jatuh_tempo']),
                    'status' => $validated['status'],
                ]);
                $order->update(['status' => 'Success']);
            }

            DB::commit(); // Simpan transaksi

            return response()->json(['success' => true, 'message' => 'Transaksi berhasil diproses!']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }
}
