<?php

namespace App\Repositories\Provider;

use LaravelEasyRepository\Repository;

interface ProviderRepository extends Repository
{

    public function getById($id);
    public function getAllData();
    public function storeData($data);
    public function updateData($data, $id);
    public function deleteData($id);
}
