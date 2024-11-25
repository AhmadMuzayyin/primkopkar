<?php

namespace App\Repositories\Service;

use LaravelEasyRepository\Repository;

interface ServiceRepository extends Repository
{
    public function getAll();
    public function getById($id);
    public function storeData(array $data);
    public function updateData(array $data, $id);
    public function deleteData($id);
}
