<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\LoanCategory\LoanCategoryRepository;
use App\Repositories\Member\MemberRepository;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanRepo, $loanCategory, $memberRepo;
    public function __construct(LoanRepository $loanRepo, LoanCategoryRepository $loanCategory, MemberRepository $memberRepo)
    {
        $this->loanRepo = $loanRepo;
        $this->loanCategory = $loanCategory;
        $this->memberRepo = $memberRepo;
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
        // dd($validated);
        try {
            $margin = $this->loanCategory->getLoanCategoryById($validated['loan_category_id'])->margin;
            $interest_rate = $validated['loan_nominal'] * $margin;
            $validated['interest_rate'] = $interest_rate;
            $validated['nominal_return'] = $validated['loan_nominal'] + $interest_rate;
            $validated['loan_date'] = date('Y-m-d');
            $this->loanRepo->createLoans($validated);
            return redirect()->back()->with('success', 'Data pinjaman berhasil disimpan');
        } catch (\Throwable $th) {
            dd($th->getMessage());
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
            $margin = $this->loanCategory->getLoanCategoryById($validated['loan_category_id'])->margin;
            $interest_rate = $validated['loan_nominal'] * $margin / 100;
            $validated['interest_rate'] = $interest_rate;
            $validated['nominal_return'] = $validated['loan_nominal'] + $interest_rate;
            $validated['loan_date'] = date('Y-m-d');
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
}
