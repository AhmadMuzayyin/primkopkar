<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\ProductRequest;
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
            Toastr::success('Berhasil menyimpan produk.');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menyimpan produk');
            return redirect()->back();
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

            Toastr::success('Berhasil memperbarui produk.');
            return to_route('products.index');
        } catch (\Throwable $th) {
            Toastr::error('Gagal memperbarui produk.');
            return redirect()->back();
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
}
