<?php

namespace App\Http\Controllers;

use App\Models\LoanCategory;
use App\Repositories\LoanCategory\LoanCategoryRepository;
use Illuminate\Http\Request;

class LoanCategoryController extends Controller
{
    protected $loanCategoryRepository;
    public function __construct(LoanCategoryRepository $loanCategoryRepository)
    {
        $this->loanCategoryRepository = $loanCategoryRepository;
    }
    public function index()
    {
        $loan_categories = $this->loanCategoryRepository->getLoanCategory();
        return view('loan_categories.index', compact('loan_categories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'margin' => 'required|numeric',
        ]);
        try {
            $this->loanCategoryRepository->createLoanCategory($data);
            return redirect()->route('loan_categories.index')->with('success', 'Berhasil menambahkan Kategori Pinjaman');
        } catch (\Throwable $th) {
            return redirect()->route('loan_categories.index')->with('error', 'Gagal menambahkan Kategori Pinjaman');
        }
    }
    public function edit(LoanCategory $loan_category)
    {
        return view('loan_categories.edit', compact('loan_category'));
    }
    public function update(Request $request, LoanCategory $loan_category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'margin' => 'required|numeric',
        ]);
        try {
            $this->loanCategoryRepository->updateLoanCategory($loan_category->id, $data);
            return redirect()->route('loan_categories.index')->with('success', 'Berhasil mengubah Kategori Pinjaman');
        } catch (\Throwable $th) {
            return redirect()->route('loan_categories.index')->with('error', 'Gagal mengubah Kategori Pinjaman');
        }
    }
    public function destroy(LoanCategory $loan_category)
    {
        try {
            $this->loanCategoryRepository->deleteLoanCategory($loan_category->id);
            return response()->json(['message' => 'Berhasil menghapus Kategori Pinjaman']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal menghapus Kategori Pinjaman']);
        }
    }
}
