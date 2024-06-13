<?php

namespace App\Repositories\Category;

use LaravelEasyRepository\Repository;

interface CategoryRepository extends Repository
{
    public function findBySlug(string $slug);
    public function getAll();
    public function storeData($request);
    public function updateData($request, $id);
    public function deleteData($id);
}
