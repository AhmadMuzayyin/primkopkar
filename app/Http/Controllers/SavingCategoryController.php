<?php

namespace App\Http\Controllers;

use App\Models\SavingCategory;
use App\Repositories\SavingCategory\SavingCategoryRepository;
use Illuminate\Http\Request;

class SavingCategoryController extends Controller
{
    protected $savingCategoryRepository;
    public function __construct(SavingCategoryRepository $savingCategoryRepository)
    {
        $this->savingCategoryRepository = $savingCategoryRepository;
    }
    public function index()
    {
        $saving_categories = $this->savingCategoryRepository->getSavingCategory();
        return view('saving_categories.index', compact('saving_categories'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $this->savingCategoryRepository->createSavingCategory($data);
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }
    }
    public function edit(SavingCategory $saving_category)
    {
        return view('saving_categories.edit', compact('saving_category'));
    }
    public function update(Request $request, SavingCategory $saving_category)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        try {
            $this->savingCategoryRepository->updateSavingCategory($saving_category->id, $data);
            return redirect()->route('saving_categories.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }
    public function destroy(SavingCategory $saving_category)
    {
        try {
            $cek = SavingCategory::with('saving_transactions')->find($saving_category->id);
            if ($cek->saving_transactions->count() > 0) {
                return response()->json(['status' => 'error', 'message' => 'Data tidak bisa dihapus karena sudah digunakan']);
            }
            $this->savingCategoryRepository->deleteSavingCategory($saving_category->id);
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus']);
        }
    }
}
