<?php

namespace App\Repositories\Member;

use LaravelEasyRepository\Repository;

interface MemberRepository extends Repository
{
    public function findById($id);
    public function getAll();
    public function storeData($request);
    public function updateData($request, $id);
    public function deleteData($id);
}
