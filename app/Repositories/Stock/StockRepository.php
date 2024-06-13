<?php

namespace App\Repositories\Stock;

use LaravelEasyRepository\Repository;

interface StockRepository extends Repository
{
    public function findById($id);
    public function getAll();
    public function storeData($request);
    public function updateData($request, $id);
    public function deleteData($id);
}
