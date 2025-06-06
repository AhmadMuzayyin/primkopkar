<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\StoreJasaRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
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

        // Dapatkan customer yang sedang aktif dari session
        $activeCustomerId = session('active_customer_id');
        $activeCustomer = null;

        if ($activeCustomerId) {
            $activeCustomer = Customer::find($activeCustomerId);
        }

        // Ambil orders dengan customer yang aktif saja
        $query = WoodShippingOrder::where('status', 'pending');
        if ($activeCustomerId) {
            $query->where('customer_id', $activeCustomerId);
        }
        $orders = $query->get();

        // Generate kode transaksi jika belum ada
        if (session('code') == null || session('code') == '') {
            session(['code' => 'JSA/' . date('Ymd') . '/' . rand(100, 999)]);
        }

        return view('transaksi_jasa.index', compact('customers', 'providers', 'orders', 'activeCustomer'));
    }

    // Tambahkan method untuk set active customer
    public function setCustomer(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);

        session(['active_customer_id' => $request->customer_id]);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dipilih'
        ]);
    }

    // Method untuk reset customer (selesai transaksi)
    public function resetCustomer()
    {
        session()->forget('active_customer_id');
        session()->forget('code');

        return response()->json([
            'success' => true,
            'message' => 'Transaksi selesai, customer direset'
        ]);
    }

    public function store(StoreJasaRequest $request)
    {
        $validated = $request->validated();

        // Pastikan customer_id dari session
        $activeCustomerId = session('active_customer_id');
        if (!$activeCustomerId) {
            return redirect()->back()->with('error', 'Silahkan pilih customer terlebih dahulu');
        }

        $validated['customer_id'] = $activeCustomerId;

        DB::beginTransaction();

        try {
            // Create Wood record
            $wood = Wood::create([
                'jenis_kayu' => $validated['jenis_kayu'],
                'volume_m3' => $validated['volume_m3'],
                'berat' => $validated['berat'],
                'panjang' => $validated['panjang'],
            ]);

            // Get provider and service details
            $provider = Provider::findOrFail($validated['provider_id']);
            $service = $provider->service;

            // Calculate shipping cost
            $shippingDetails = $this->calculate(
                volume: $validated['volume_m3'],
                shippingType: $validated['jenis_pengiriman'],
                pricePerM3: $service->harga_per_m3,
                pricePerShipment: $service->harga_per_angkutan,
                maxCapacity: $service->volume_max
            );

            // Create shipping order
            WoodShippingOrder::create([
                'code' => session('code'),
                'customer_id' => $validated['customer_id'],
                'provider_id' => $validated['provider_id'],
                'wood_id' => $wood->id,
                'tgl_pesanan' => $validated['tgl_pesanan'],
                'tgl_kirim' => $validated['tgl_kirim'],
                'lokasi_pengambilan' => $validated['lokasi_pengambilan'],
                'lokasi_pengantaran' => $validated['lokasi_pengantaran'],
                'jenis_pengiriman' => $validated['jenis_pengiriman'],
                'harga_per_m3' => $service->harga_per_m3,
                'harga_per_angkutan' => $service->harga_per_angkutan,
                'kapasitas_angkutan_m3' => $service->volume_max,
                'total_biaya' => $shippingDetails['total_cost'],
                'jumlah_angkutan' => $shippingDetails['number_of_shipments'] ?? null,
            ]);


            DB::commit(); // Simpan semua perubahan jika tidak ada error

            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil dibuat!');
        } catch (\Throwable $th) {
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

            // Update data WoodShippingOrder - jangan update customer_id
            $order->update([
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

    public function proses(Request $request)
    {
        $validated = $request->validate([
            'biaya_operasional' => 'required|numeric',
            'metode_bayar' => 'required|in:Cash,Transfer',
        ]);

        $code = session('code');
        $customerId = session('active_customer_id');

        if (empty($code) || empty($customerId)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode transaksi atau customer tidak ditemukan!'
            ]);
        }

        try {
            DB::beginTransaction();

            // Ambil semua order pending dengan kode yang sama dan customer yang dipilih
            $orders = WoodShippingOrder::with(['wood', 'customer'])
                ->where('status', 'pending')
                ->where('code', $code)
                ->where('customer_id', $customerId)
                ->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pesanan yang perlu dibayar!'
                ]);
            }

            $totalHarga = $orders->sum('total_biaya');
            $customer = $orders->first()->customer;

            // Buat payment 
            $payment = Payment::create([
                'code' => $code,
                'customer_id' => $customerId,
                'tgl_bayar' => now(),
                'jumlah_bayar' => $totalHarga,
                'biaya_operasional' => $validated['biaya_operasional'],
                'metode_bayar' => $validated['metode_bayar'],
                'payment_reference' => 'JSA/' . date('Ymd') . '/' . strtoupper(substr(uniqid(), -3)),
            ]);

            // Update status orders
            $orders->each(function ($order) use ($payment) {
                $order->update([
                    'status' => 'success',
                    'payment_id' => $payment->id
                ]);
            });

            // Siapkan data untuk struk
            $orderDetails = $orders->map(function ($order) {
                return [
                    'jenis_kayu' => $order->wood->jenis_kayu,
                    'volume_m3' => $order->wood->volume_m3,
                    'jenis_pengiriman' => $order->jenis_pengiriman,
                    'biaya' => $order->total_biaya,
                ];
            });

            $result = [
                'payment_reference' => $payment->code,
                'tgl_bayar' => $payment->tgl_bayar->format('d/m/Y H:i:s'),
                'metode_bayar' => $payment->metode_bayar,
                'customer' => [
                    'nama' => $customer->nama,
                    'alamat' => $customer->alamat,
                ],
                'orders' => $orderDetails,
                'total_biaya' => $totalHarga,
                'biaya_operasional' => $payment->biaya_operasional,
                'total_keseluruhan' => $totalHarga + $payment->biaya_operasional
            ];

            session()->forget('code');
            session()->forget('active_customer_id');
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diproses!',
                'data' => [$result]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ]);
        }
    }

    public function calculate(
        float $volume,
        string $shippingType,
        float $pricePerM3,
        float $pricePerShipment,
        float $maxCapacity
    ): array {
        if ($volume <= 0) {
            throw new \InvalidArgumentException('Volume harus lebih besar dari 0');
        }

        if ($shippingType === 'Per M3') {
            return [
                'shipping_type' => 'Per M3',
                'volume' => $volume,
                'price_per_unit' => $pricePerM3,
                'total_cost' => $volume * $pricePerM3,
                'calculation_details' => "Volume {$volume} m³ × Rp {$pricePerM3}"
            ];
        }

        if ($shippingType === 'Per Angkutan') {
            $numberOfShipments = ceil($volume / $maxCapacity);
            $totalCost = $numberOfShipments * $pricePerShipment;

            return [
                'shipping_type' => 'Per Angkutan',
                'volume' => $volume,
                'capacity_per_shipment' => $maxCapacity,
                'number_of_shipments' => $numberOfShipments,
                'price_per_shipment' => $pricePerShipment,
                'total_cost' => $totalCost,
                'calculation_details' => "Jumlah angkutan: {$numberOfShipments} × Rp {$pricePerShipment}"
            ];
        }

        throw new \InvalidArgumentException('Jenis pengiriman tidak valid');
    }
}
