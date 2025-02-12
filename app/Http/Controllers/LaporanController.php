<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\SavingTrasaction;
use App\Repositories\Saving\SavingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }
    // laporan toko
    public function piutangMember()
    {
        if (request()->ajax()) {
            $member_with_piutang = Member::select('members.id', 'members.nama')
                ->join('product_transactions', 'members.id', '=', 'product_transactions.member_id')
                ->where('product_transactions.amount_price', 0)
                ->select('members.id', 'members.name', 'members.address', 'members.phone', DB::raw('SUM(CASE WHEN product_transactions.type = "credit" THEN product_transactions.amount ELSE 0 END) as credit'))
                ->groupBy('members.id', 'members.name', 'members.address', 'members.phone',)
                ->get();
            return DataTables::of($member_with_piutang)
                ->addIndexColumn()
                ->addColumn('action', 'laporan.include.piutangBTN')
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function updatePiutangMember(Request $request)
    {
        if (request()->ajax()) {
            $validator = Validator::make($request->all(), [
                'member_id' => 'required|exists:members,id',
                'nominal' => 'required|numeric|min:1',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                $piutangMemberNominal = ProductTransaction::where('member_id', $request->member_id)
                    ->where('type', 'Credit')
                    ->where('amount_price', 0)
                    ->sum('amount');
                if ($request->nominal < $piutangMemberNominal) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Nominal tidak boleh kurang dari jumlah piutang.'
                    ], 422);
                } else {
                    ProductTransaction::where('member_id', $request->member_id)
                        ->where('type', 'Credit')
                        ->where('amount_price', 0)
                        ->update([
                            'amount_price' => $request->nominal
                        ]);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil diupdate'
                    ]);
                }
            }
        }
    }
    public function perBarang()
    {
        if (request()->ajax()) {
            $from = request()->from;
            $to = request()->to;
            $products = Product::select(
                'products.id',
                'products.name',
                'products.price',
                'products.purchase_price',
                'products.price_credit',
                'products.stock',
                DB::raw('SUM(product_item_transactions.quantity) as total_sold'),
                DB::raw('SUM(product_transactions.amount) as total_revenue')
            )
                ->join('product_item_transactions', 'products.id', '=', 'product_item_transactions.product_id')
                ->join('product_transactions', 'product_item_transactions.product_transaction_id', '=', 'product_transactions.id')
                ->when($from && $to, function ($query) use ($from, $to) {
                    return $query->whereBetween('product_transactions.created_at', [
                        $from,
                        $to
                    ]);
                })
                ->groupBy(
                    'products.id',
                    'products.name',
                    'products.price',
                    'products.purchase_price',
                    'products.price_credit',
                    'products.stock'
                )
                ->get();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('total_sold', function ($product) {
                    return $product->total_sold;
                })
                ->addColumn('total_revenue', function ($product) {
                    return $product->total_revenue;
                })
                ->make(true);
        }
    }
    public function jasa(Request $request)
    {
        if ($request->ajax()) {
            $query = Invoice::with(['woodShippingOrder.wood', 'woodShippingOrder.customer', 'woodShippingOrder.provider'])
                ->when($request->from && $request->to, function ($q) use ($request) {
                    return $q->whereBetween('tgl_faktur', [$request->from, $request->to]);
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('pelanggan', function ($row) {
                    return $row->woodShippingOrder->customer->nama ?? '-';
                })
                ->addColumn('bkph', function ($row) {
                    return $row->woodShippingOrder->provider->bkph->nama ?? '-';
                })
                ->addColumn('provider', function ($row) {
                    return $row->woodShippingOrder->provider->nama ?? '-';
                })
                ->addColumn('total', function ($row) {
                    return $row->total_pembayaran;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->rawColumns(['pelanggan', 'bkph', 'provider', 'total', 'status'])
                ->make(true);
        }

        return response()->json(['error' => 'Bad Request'], 400);
    }
    public function simpanan(Request $request)
    {
        if ($request->ajax()) {
            $query = SavingTrasaction::with('member', 'savingCategory')
                ->when($request->from && $request->to, function ($q) use ($request) {
                    return $q->whereBetween('tgl_faktur', [$request->from, $request->to]);
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('member', function ($row) {
                    return $row->member->name ?? '-';
                })
                ->addColumn('debit_credit', function ($row) {
                    return $row->transaction_type == 'Setoran' ? 'Debit' : 'Credit' ?? '-';
                })
                ->addColumn('kategori', function ($row) {
                    return $row->savingCategory->name ?? '-';
                })
                ->addColumn('saldo', function ($row) {
                    return $row->nominal ?? '-';
                })
                ->rawColumns(['member', 'kategori', 'saldo',])
                ->make(true);
        }

        return response()->json(['error' => 'Bad Request'], 400);
    }
    public function pinjaman(Request $request)
    {
        if ($request->ajax()) {
            $query = Loan::with('member', 'loan_category', 'loan_payment')
                ->when($request->from && $request->to, function ($q) use ($request) {
                    return $q->whereBetween('tgl_faktur', [$request->from, $request->to]);
                });

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('member', function ($row) {
                    return $row->member->name ?? '-';
                })
                ->addColumn('nominal', function ($row) {
                    return $row->loan_nominal ?? '-';
                })
                ->addColumn('tgl_pinjaman', function ($row) {
                    return $row->loan_date ?? '-';
                })
                ->addColumn('tgl_pelunasan', function ($row) {
                    return $row->loan_periode ?? '-';
                })
                ->addColumn('angsuran', function ($row) {
                    return $row->interest_rate ?? '-';
                })
                ->rawColumns(['member', 'nominal', 'tgl_pinjaman', 'tgl_pelunasan', 'angsuran'])
                ->make(true);
        }

        return response()->json(['error' => 'Bad Request'], 400);
    }
}
