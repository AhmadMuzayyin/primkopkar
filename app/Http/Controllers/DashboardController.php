<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Loan;
use App\Models\ProductTransaction;
use App\Models\SavingTrasaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $toko = ProductTransaction::where('status', '1')->sum('amount');
        $simpanan = SavingTrasaction::where('transaction_type', 'Setoran')->sum('nominal');
        $pinjaman = Loan::where('status', 'Lunas')->sum('nominal_return');
        $jasa = Invoice::where('status', 'Lunas')->sum('total_pembayaran');
        return view('dashboard', compact('toko', 'simpanan', 'pinjaman', 'jasa'));
    }
}
