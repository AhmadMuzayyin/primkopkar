<?php

namespace App\Repositories\ProductTransaction;

use App\Models\ProductTransaction;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductTransactionRepositoryImplement extends Eloquent implements ProductTransactionRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(ProductTransaction $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->whereId($id)->first();
    }

    public function getAll()
    {
        return $this->model->where('status', false)->get();
    }

    public function getLatestTransaction()
    {
        return $this->model->where('status', false)->latest()->first();
    }

    public function store($request)
    {
        $productTransaction = $this->model->create($request);

        return $productTransaction;
    }

    public function update($request, $id)
    {
        $productTransaction = $this->model->find($id);
        $productTransaction->update($request);

        return $productTransaction;
    }

    public function deleteData($id)
    {
        return $this->model->find($id)->delete();
    }
}
