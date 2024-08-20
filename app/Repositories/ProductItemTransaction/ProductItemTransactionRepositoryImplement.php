<?php

namespace App\Repositories\ProductItemTransaction;

use App\Models\ProductItemTransaction;
use Exception;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductItemTransactionRepositoryImplement extends Eloquent implements ProductItemTransactionRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(ProductItemTransaction $model)
    {
        $this->model = $model;
    }

    public function findByTransactionId($transactionId, $productId)
    {
        return $this->model->where('product_transaction_id', $transactionId)->where('product_id', $productId)->first();
    }

    public function findById($transactionId)
    {
        try {
            return $this->model->where('product_transaction_id', $transactionId)->get();
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store($request)
    {
        return $this->model->create($request);
    }

    public function updateData($request, $transactionId, $productId)
    {
        return $this->model->where('product_transaction_id', $transactionId)->where('product_id', $productId)->update($request);
    }

    public function deleteData($transactionId, $productId)
    {
        return $this->model->where('product_transaction_id', $transactionId)->where('product_id', $productId)->delete();
    }
}
