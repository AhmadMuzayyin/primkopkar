<?php

namespace App\Http\Controllers;

use App\Helpers\Toastr;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $categories = $this->categories->getAll();

        return view('categories.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $validate = $request->validated();
        try {
            $this->categories->storeData($validate);
            Toastr::success('Berhasil menambah kategori.');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan kategori.');

            return redirect()->back();
        }
    }

    public function edit($categories)
    {
        $category = $this->categories->findBySlug($categories);

        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $categories)
    {
        $validate = $request->validated();
        try {
            $this->categories->updateData($validate, $categories);
            Toastr::success('Berhasil merubah data.');

            return to_route('category.index');
        } catch (\Throwable $th) {
            Toastr::error('Gagal merubah data.');

            return redirect()->back();
        }
    }

    public function destroy($categories)
    {
        try {
            $this->categories->deleteData($categories);

            return response()->json(['message' => 'Berhasil menghapus data.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal menghapus data.'], 500);
        }
    }
}
