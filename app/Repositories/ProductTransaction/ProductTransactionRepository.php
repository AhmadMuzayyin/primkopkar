<?php

namespace App\Repositories\ProductTransaction;

use LaravelEasyRepository\Repository;

interface ProductTransactionRepository extends Repository
{
    public function getById($id);

    public function getAll();

    public function getLatestTransaction();

    public function store($request);

    public function update($request, $id);

    public function deleteData($id);
}
