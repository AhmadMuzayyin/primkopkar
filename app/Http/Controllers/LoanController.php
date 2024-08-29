<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\LoanCategory\LoanCategoryRepository;
use App\Repositories\LoanPayment\LoanPaymentRepository;
use App\Repositories\Member\MemberRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanRepo, $loanCategory, $memberRepo, $paymentRepo;
    public function __construct(LoanRepository $loanRepo, LoanCategoryRepository $loanCategory, MemberRepository $memberRepo, LoanPaymentRepository $paymentRepo)
    {
        $this->loanRepo = $loanRepo;
        $this->loanCategory = $loanCategory;
        $this->memberRepo = $memberRepo;
        $this->paymentRepo = $paymentRepo;
    }
    public function index()
    {
        $categories = $this->loanCategory->getLoanCategory();
        $loans = $this->loanRepo->getLoans();
        $members = $this->memberRepo->getAll();
        return view('loans.index', compact('loans', 'categories', 'members'));
    }
    public function store(LoanRequest $request)
    {
        $validated = $request->validated();
        try {
            $loanPeriod = $validated['loan_period'];
            $currentDate = now();
            $margin = $this->loanCategory->getLoanCategoryById($validated['loan_category_id'])->margin;
            $interest_rate = (($validated['loan_nominal'] * $margin) / 100) * $loanPeriod;
            $validated['interest_rate'] = $interest_rate;
            $validated['nominal_return'] = $validated['loan_nominal'] + $interest_rate;
            $validated['loan_date'] = date('Y-m-d');
            $validated['loan_period'] = $currentDate->addDays(intval($loanPeriod));
            $validated['status'] = 'Belum Lunas';
            $userLoan = $this->loanRepo->getLoanActive($validated['member_id'], $validated['loan_category_id']);
            if ($userLoan) {
                $userPeriode = new Carbon($userLoan->loan_period);
                $validated['loan_nominal'] += $userLoan->loan_nominal;
                $validated['interest_rate'] += $userLoan->interest_rate;
                $validated['nominal_return'] += $userLoan->nominal_return;
                $validated['loan_period'] = $userPeriode->addDays(intval($loanPeriod));
                $this->loanRepo->updateLoans($validated, $userLoan->id);
            } else {
                $this->loanRepo->createLoans($validated);
            }
            return redirect()->back()->with('success', 'Data pinjaman berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Data pinjaman gagal disimpan');
        }
    }
    public function edit(Loan $loan)
    {
        $categories = $this->loanCategory->getLoanCategory();
        $members = $this->memberRepo->getAll();
        return view('loans.edit', compact('loan', 'categories', 'members'));
    }
    public function update(Loan $loan, LoanRequest $request)
    {
        $validated = $request->validated();
        try {
            $loanPeriod = $validated['loan_period'];
            $userPeriode = new Carbon($loan->created_at);
            $margin = $this->loanCategory->getLoanCategoryById($validated['loan_category_id'])->margin;
            $interest_rate = (($validated['loan_nominal'] * $margin) / 100) * $loanPeriod;
            $validated['interest_rate'] = $interest_rate;
            $validated['nominal_return'] = $validated['loan_nominal'] + $interest_rate;
            $validated['loan_period'] = $userPeriode->addDays(intval($loanPeriod));
            $this->loanRepo->updateLoans($validated, $loan->id);
            return redirect()->route('loans.index')->with('success', 'Data pinjaman berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Data pinjaman gagal diubah');
        }
    }
    public function destroy(Loan $loan)
    {
        try {
            $this->loanRepo->deleteLoans($loan->id);
            return response()->json(['status' => 'success', 'message' => 'Data pinjaman berhasil di hapus']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'danger', 'message' => 'Data pinjaman gagal di hapus']);
        }
    }

    // loan payment method
    public function payment(Loan $loan, Request $request)
    {
        $validated = $request->validate([
            'nominal' => 'required|numeric'
        ]);
        try {
            $userLoan = $loan->loan_nominal + $loan->interest_rate;
            $data = [
                'loan_id' => $loan->id,
                'return_date' => date('Y-m-d'),
                'nominal_installment' => $validated['nominal'],
                'temporary_total_return' => $userLoan - $validated['nominal']
            ];
            $secondPayment = $loan->loan_payment();
            if ($secondPayment) {
                $total_payment = $secondPayment->sum('nominal_installment');
                if ($total_payment + $validated['nominal'] > $userLoan) {
                    return response()->json(['status' => 'error', 'message' => 'Pembayaran melebihi total pinjaman']);
                }
                if ($total_payment + $validated['nominal'] == $userLoan) {
                    $this->loanRepo->updateLoans(['status' => 'Lunas'], $loan->id);
                    $loanPayments = $this->paymentRepo->createLoanPayments($data);
                    return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil', 'data' => $loanPayments]);
                }
            }
            $loanPayments = $this->paymentRepo->createLoanPayments($data);
            return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil', 'data' => $loanPayments]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Pembayaran gagal']);
        }
    }
}
