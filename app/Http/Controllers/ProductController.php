<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Stock\StockRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $products;
    protected $stock;
    public function __construct(ProductRepository $products, StockRepository $stock)
    {
        $this->products = $products;
        $this->stock = $stock;
    }
    public function index()
    {
        $products = $this->products->getAll();
        $categories = $this->products->getCategory();
        return view('products.index', compact('products', 'categories'));
    }
    public function store(ProductRequest $request)
    {
        $validate = $request->validated();
        try {
            $product = $this->products->storeData($validate);
            $stock = ['product_id' => $product->id, 'stock' => $validate['stock']];
            $this->stock->storeData($stock);
            // Toastr::success('Berhasil menyimpan produk.');
            // return redirect()->back();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan produk'
            ], 200);
        } catch (\Throwable $th) {
            // Toastr::error('Gagal menyimpan produk');
            // return redirect()->back();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan produk'
            ], 500);
        }
    }
    public function edit($products)
    {
        $product = $this->products->findById($products);
        $categories = $this->products->getCategory();
        return view('products.edit', compact('product', 'categories'));
    }
    public function update(ProductRequest $request, $products)
    {
        $validate = $request->validated();
        try {
            $this->products->updateData($validate, $products);
            // update stock
            $stockRequest = ['product_id' => $products, 'stock' => $validate['stock']];
            $product = $this->products->findById($products);
            $stock = $this->stock->findByProductId($product->id);
            $this->stock->updateData($stockRequest, $stock->id);

            // Toastr::success('Berhasil memperbarui produk.');
            // return to_route('products.index');
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memperbarui produk'
            ], 200);
        } catch (\Throwable $th) {
            // Toastr::error('Gagal memperbarui produk.');
            // return redirect()->back();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui produk'
            ], 500);
        }
    }
    public function destroy($products)
    {
        try {
            $this->products->deleteData($products);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }
    public function print(Request $request)
    {
        try {
            $barcodes = $request->query('barcodes');
            if ($barcodes) {
                // Pisahkan barcodes menjadi array
                $barcodeArray = explode(',', $barcodes);

                // Ambil data produk berdasarkan barcode
                $products = Product::whereIn('barcode', $barcodeArray)->get();
                // Anda bisa mengembalikan view dengan data produk untuk mencetak barcode
                return view('products.barcode', compact('products'));
            } else {
                return redirect()->back()->with('error', 'Tidak ada barcode yang dipilih');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
