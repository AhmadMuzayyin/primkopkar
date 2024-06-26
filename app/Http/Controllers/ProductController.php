<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\ProductRequest;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $products;
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }
    public function index()
    {
        $products = $this->products->getAll();
        $category = $this->products->getCategory();
        return view('products.index', compact('products'));
    }
    public function store(ProductRequest $request)
    {
        $validate = $request->validated();
        try {
            $this->products->storeData($validate);
            Toastr::success('Berhasil menyimpan produk.');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan produk');
            return redirect()->back();
        }
    }
    public function edit($products)
    {
        $product = $this->products->findById($products);
        return view('products.edit', compact('product'));
    }
    public function update(ProductRequest $request, $products)
    {
        $validate = $request->validated();
        try {
            $this->products->updateData($validate, $products);
            Toastr::success('Berhasil memperbarui produk.');
        } catch (\Throwable $th) {
            Toastr::error('Gagal memperbarui produk.');
            return redirect()->back();
        }
    }
    public function destroy($products)
    {
        try {
            $this->products->deleteData($products);
            Toastr::success('Berhasil menghapus data.');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');
            return redirect()->back();
        }
    }
}
