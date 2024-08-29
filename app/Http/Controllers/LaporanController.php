<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\ProductTransaction;
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
                    ->sum('amount');
                if ($request->nominal < $piutangMemberNominal) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Nominal tidak boleh kurang dari jumlah piutang.'
                    ], 422);
                } else {
                    ProductTransaction::where('member_id', $request->member_id)
                        ->where('type', 'Credit')
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
                DB::raw('SUM(product_item_transactions.price * product_item_transactions.quantity) as total_revenue')
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
}
