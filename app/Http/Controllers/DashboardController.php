<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Payment;
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
        $jasa = Payment::sum('jumlah_bayar') + Payment::sum('biaya_operasional');

        $pertokoanChart = ProductTransaction::where('status', '1')
            ->whereYear('transaction_date', date('Y'))
            ->selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'y' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'b' => $item->total
                ];
            });
        $simpananChart = SavingTrasaction::where('transaction_type', 'Setoran')
            ->whereYear('saving_date', date('Y'))
            ->selectRaw('MONTH(saving_date) as month, SUM(nominal) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'y' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'b' => $item->total
                ];
            });
        $pinjamanChart = LoanPayment::whereYear('return_date', date('Y'))
            ->selectRaw('MONTH(return_date) as month, SUM(nominal_installment) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'y' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'b' => $item->total
                ];
            });
        $jasaChart = Payment::whereYear('tgl_bayar', date('Y'))
            ->selectRaw('MONTH(tgl_bayar) as month, SUM(jumlah_bayar + biaya_operasional) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'y' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'b' => $item->total
                ];
            });
        return view('dashboard', compact(
            'toko',
            'simpanan',
            'pinjaman',
            'jasa',
            'pertokoanChart',
            'simpananChart',
            'pinjamanChart',
            'jasaChart'
        ));
    }
}
