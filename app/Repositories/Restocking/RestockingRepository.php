<?php

namespace App\Repositories\Restocking;

use LaravelEasyRepository\Repository;

interface RestockingRepository extends Repository
{

    public function all();

    public function findById(int $id);

    public function createData(array $data);

    public function updateData(int $id, array $data);

    public function deleteData(int $id);
}
