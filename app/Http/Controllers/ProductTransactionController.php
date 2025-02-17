<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductItemTransaction\ProductItemTransactionRepository;
use App\Repositories\ProductTransaction\ProductTransactionRepository;
use App\Repositories\Stock\StockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductTransactionController extends Controller
{
    protected $product;

    protected $productTransaction;

    protected $itemTransaction;

    protected $stok;

    public function __construct(ProductTransactionRepository $productTransaction, ProductItemTransactionRepository $itemTransaction, ProductRepository $product, StockRepository $stok)
    {
        $this->product = $product;
        $this->productTransaction = $productTransaction;
        $this->itemTransaction = $itemTransaction;
        $this->stok = $stok;
    }

    public function index()
    {
        $transactions = $this->productTransaction->getAll();
        $members = Member::all();

        return view('product_transactions.index', compact('transactions', 'members'));
    }

    public function find(Request $request)
    {
        try {
            $product = Product::where('barcode', $request['param'])->orWhere('name', 'like', '%' . $request['param'] . '%')->first();

            return response()->json([
                'status' => 'success',
                'data' => $product,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menemukan produk',
            ], 500);
        }
    }

    public function store(Request $request, Product $product)
    {
        $validate = Validator::make($request->all(), [
            'qty' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($product) {
                    if ($value > $product->stock) {
                        $fail('Jumlah tidak boleh lebih dari stok yang tersedia.');
                    }
                },
            ],
        ]);
        try {
            if ($validate->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validate->errors()->first(),
                ], 422);
            }
            $last = $this->productTransaction->getLatestTransaction();
            if (!$last) {
                $transactionRequest = [
                    'user_id' => Auth::user()->id,
                    'code' => fake()->unique()->randomNumber(6),
                    'transaction_date' => now(),
                    'amount' => $product->price * $request->qty,
                ];
                $productTransaction = $this->productTransaction->store($transactionRequest);
                $itemRequest = [
                    'product_transaction_id' => $productTransaction->id, // 'id' => 'product_transaction_id
                    'product_id' => $product->id,
                    'quantity' => $request->qty,
                    'price' => $product->price,
                    'margin' => $product->margin,
                    'shu' => $product->shu,
                ];
                $this->itemTransaction->create($itemRequest);
            } else {
                $price = $product->price * $request->qty;
                $transactionRequest = [
                    'amount' => $last->amount + $price,
                ];
                $this->productTransaction->update($transactionRequest, $last->id);
                $lastitemTransaction = $this->itemTransaction->findByTransactionId($last->id, $product->id);
                if ($lastitemTransaction) {
                    $itemRequest = [
                        'quantity' => $lastitemTransaction->quantity + $request->qty,
                    ];
                    $this->itemTransaction->updateData($itemRequest, $last->id, $product->id);
                } else {
                    $itemRequest = [
                        'product_transaction_id' => $last->id, // 'id' => 'product_transaction_id
                        'product_id' => $product->id,
                        'quantity' => $request->qty,
                        'price' => $product->price,
                        'margin' => $product->margin,
                        'shu' => $product->shu,
                    ];
                    $this->itemTransaction->create($itemRequest);
                }
            }
            Toastr::success('Berhasil menyimpan transaksi.');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menyimpan transaksi');

            return redirect()->back();
        }
    }

    public function destroy(ProductTransaction $product_transaction)
    {
        try {
            $product_transaction->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data',
                'error' => $th->getMessage(),
            ], 422);
        }
    }

    public function delete(ProductTransaction $product_transaction, Product $product)
    {
        try {
            $itemTransaction = $this->itemTransaction->findByTransactionId($product_transaction->id, $product->id);
            if ($itemTransaction->quantity == 1) {
                $this->productTransaction->deleteData($product_transaction->id);
            } else {
                $this->itemTransaction->deleteData($product_transaction->id, $product->id);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus produk dari transaksi',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus produk dari transaksi',
                'error' => $th->getMessage(),
            ], 422);
        }
    }

    public function bayar(Request $request, ProductTransaction $product_transaction)
    {
        $request->validate([
            'paymentMethod' => 'required:in,Cash,Credit',
            'price' => 'required_if:paymentMethod,Cash|numeric',
        ]);
        // dd($request->all());
        try {
            if ($request->paymentMethod == 'Credit') {
                $request->validate([
                    'member_id' => 'required|exists:members,id',
                ]);
            }
            if ($request->paymentMethod == 'Cash') {
                if (str_replace('.', '', $request->price) < $product_transaction->amount) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Uang yang dibayarkan kurang dari total harga',
                    ], 422);
                } else {
                    $amount_price = str_replace('.', '', $request->price);
                    $transactionRequest = [
                        'member_id' => $request->member_id,
                        'status' => true,
                        'amount_price' => $amount_price,
                    ];
                    $items = $this->itemTransaction->findById($product_transaction->id);
                    foreach ($items as $key => $value) {
                        $product = $this->product->findById($value->product_id);
                        $productRequest = [
                            'stock' => $product->stock - $value->quantity,
                        ];
                        $this->product->updateStock($productRequest, $value->product_id);
                        $this->stok->updateStock($productRequest, $value->product_id);
                    }
                    $this->productTransaction->update($transactionRequest, $product_transaction->id);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Berhasil menyimpan transaksi',
                        'data' => $this->productTransaction->getById($product_transaction->id),
                    ]);
                }
            } else {
                $transactionRequest = [
                    'member_id' => $request->member_id,
                    'status' => true,
                    'amount_price' => 0,
                    'type' => 'Credit',
                ];
                $amount = 0;
                $items = $this->itemTransaction->findById($product_transaction->id);
                foreach ($items as $key => $value) {
                    $product = $this->product->findById($value->product_id);
                    // prepare data for update stock
                    $productRequest = [
                        'stock' => $product->stock - $value->quantity,
                    ];
                    $this->product->updateStock($productRequest, $value->product_id);
                    $this->stok->updateStock($productRequest, $value->product_id);

                    // prepare data for update transaction
                    $amount += $product->price_credit * $value->quantity;
                }
                $transactionRequest['amount'] = $amount;
                // prepare data for update transaction
                $data = $this->productTransaction->update($transactionRequest, $product_transaction->id);

                // dd($data);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil menyimpan transaksi',
                    'data' => $data,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan transaksi',
                'error' => $th->getMessage(),
            ], 422);
        }
    }

    public function save(Request $request)
    {
        $product = $this->productTransaction->getById($request->product_transaction_id);
        $items = $this->itemTransaction->findById($request->product_transaction_id);

        return view('product_transactions.print', compact('product', 'items'));
    }
}
