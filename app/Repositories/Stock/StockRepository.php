<?php

namespace App\Repositories\Stock;

use LaravelEasyRepository\Repository;

interface StockRepository extends Repository
{
    public function findById($id);
    public function findByProductId($product_id);
    public function getAll();
    public function updateData($request, $id);
    public function deleteData($id);
}
