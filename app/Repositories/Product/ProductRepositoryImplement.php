<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use Exception;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    public function findById($id)
    {
        return $this->model->whereId($id)->first();
    }
    public function findByBarcode($barcode)
    {
        return $this->model->where('barcode', $barcode)->first();
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getCategory()
    {
        return Category::all();
    }
    public function storeData($request)
    {
        try {
            return $this->model->create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function updateData($request, $id)
    {
        try {
            $this->model->whereId($id)->update($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function updateStock($request, $id)
    {
        try {
            $this->model->whereId($id)->update($request);
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
