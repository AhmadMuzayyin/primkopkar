<?php

namespace App\Repositories\ProductItemTransaction;

use LaravelEasyRepository\Repository;

interface ProductItemTransactionRepository extends Repository
{
    public function findByTransactionId($transactionId, $productId);

    public function findById($transactionId);

    public function store($request);

    public function updateData($request, $transactionId, $productId);

    public function deleteData($transactionId, $productId);
}
