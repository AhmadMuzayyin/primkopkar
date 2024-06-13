<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Exception;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function storeData($request)
    {
        try {
            $this->model->create($request->all());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function updateData($request, $id)
    {
        try {
            $this->model->whereId($id)->update($request->all());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function deleteData($id)
    {
        try {
            $this->model->whereId($id)->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
