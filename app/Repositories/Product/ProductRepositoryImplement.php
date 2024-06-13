<?php

namespace App\Repositories\Product;

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
