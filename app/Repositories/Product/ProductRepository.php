<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function findById($id);
    public function findByBarcode($barcode);
    public function getAll();
    public function getCategory();
    public function storeData($request);
    public function updateData($request, $id);
    public function updateStock($request, $id);
    public function deleteData($id);
}
