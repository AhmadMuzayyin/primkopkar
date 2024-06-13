<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository
{
    public function findByEmail(string $email);

    public function findById($id);

    public function getAll();

    public function storeData($request);

    public function updateData($request, $id);

    public function deleteData($id);
}
