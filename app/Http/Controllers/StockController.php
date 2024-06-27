<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\StockRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Stock\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stocks;
    protected $product;
    public function __construct(StockRepository $stocks, ProductRepository $product)
    {
        $this->stocks = $stocks;
        $this->product = $product;
    }
    public function index()
    {
        $stocks = $this->stocks->getAll();
        $stocks->load('product');
        return view('stocks.index', compact('stocks'));
    }
    public function update(StockRequest $request, $stocks)
    {
        $validate = $request->validated();
        try {
            $this->stocks->updateData($validate, $stocks);
            $this->product->updateStock($validate['stock'], $validate['product_id']);
            Toastr::success('Berhasil memperbarui stok.');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal memperbarui stok.');
            return redirect()->back();
        }
    }
    public function destroy($stocks)
    {
        try {
            $stockData = $this->stocks->findById($stocks);
            $this->product->updateStock(0, $stockData->product_id);
            $this->stocks->deleteData($stocks);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus data'], 500);
        }
    }
}
