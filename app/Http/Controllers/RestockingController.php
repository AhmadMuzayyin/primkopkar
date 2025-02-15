<?php

namespace App\Http\Controllers;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Restocking\RestockingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestockingController extends Controller
{
    protected $restocking, $products;
    public function __construct(RestockingRepository $restocking, ProductRepository $products)
    {
        $this->restocking = $restocking;
        $this->products = $products;
    }
    public function index()
    {
        $restockings = $this->restocking->all();
        $products = $this->products->getAll();
        return view('restocking.index', compact('restockings', 'products'));
    }
    public function create()
    {
        return view('restocking.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'purchase_price' => 'required|numeric|min:1000',
            'stock' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $validate['user_id'] = auth()->user()->id;
            $this->restocking->create($validate);
            $product = $this->products->find($validate['product_id']);
            $productData = [
                'stock' => $validate['stock'] + $product->stock,
                'purchase_price' => $validate['purchase_price'],
            ];
            $this->products->updateData($productData, $validate['product_id']);
            DB::commit();
            return redirect()->route('restocking.index')->with('success', 'Kulakan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('restocking.index')->with('error', 'Gagal membuat kulakan.');
        }
    }
    public function edit($id)
    {
        try {
            $restocking = $this->restocking->find($id);
            $products = $this->products->getAll();
            return view('restocking.edit', compact('restocking', 'products'));
        } catch (\Exception $e) {
            return redirect()->route('restocking.index')->with('error', 'Gagal menemukan kulakan.');
        }
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'purchase_price' => 'required|numeric|min:1000',
            'stock' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();
        try {
            $restocking = $this->restocking->findById($id);
            $product = $this->products->find($validate['product_id']);
            $stock = $product->stock - $restocking->stock;
            $productData = [
                'stock' => $validate['stock'] + $stock,
                'purchase_price' => $validate['purchase_price'],
            ];
            $restocking->update($validate);
            $product->update($productData);
            DB::commit();
            return redirect()->route('restocking.index')->with('success', 'Kulakan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('restocking.index')->with('error', 'Gagal memperbarui kulakan.');
        }
    }
    public function destroy($id)
    {
        try {
            $this->restocking->delete($id);
            return response()->json(['status' => 'success', 'message' => 'Kulakan berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus kulakan.']);
        }
    }
    public function getProduct($id)
    {
        $product = $this->products->find($id);
        return response()->json([
            'purchase_price' => $product->pluck('purchase_price'),
            'stock' => $product->pluck('stock'),
        ]);
    }
}
