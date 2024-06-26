<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\StockRequest;
use App\Repositories\Stock\StockRepository;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stocks;
    public function __construct(StockRepository $stocks)
    {
        $this->stocks = $stocks;
    }
    public function index()
    {
        $stocks = $this->stocks->getAll();
        return view('stocks.index', compact('stocks'));
    }
    public function store(StockRequest $request)
    {
        $validate = $request->validated();
        try {
            $this->stocks->storeData($validate);
            Toastr::success('Berhasil menyimpan stok.');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan stok');
            return redirect()->back();
        }
    }
    public function edit($stocks)
    {
        $stock = $this->stocks->findById($stocks);
        return view('stocks.edit', compact('stock'));
    }
    public function update(StockRequest $request, $stocks)
    {
        $validate = $request->validated();
        try {
            $this->stocks->updateData($validate, $stocks);
            Toastr::success('Berhasil memperbarui stok.');
        } catch (\Throwable $th) {
            Toastr::error('Gagal memperbarui stok.');
            return redirect()->back();
        }
    }
    public function destroy($stocks)
    {
        try {
            $this->stocks->deleteData($stocks);
            Toastr::success('Berhasil menghapus data.');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');
            return redirect()->back();
        }
    }
}
