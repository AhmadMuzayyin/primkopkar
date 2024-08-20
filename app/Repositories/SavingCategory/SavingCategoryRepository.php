<?php

namespace App\Repositories\SavingCategory;

use LaravelEasyRepository\Repository;

interface SavingCategoryRepository extends Repository
{

    public function getSavingCategory();
    public function getSavingCategoryById($id);
    public function createSavingCategory($data);
    public function updateSavingCategory($id, $data);
    public function deleteSavingCategory($id);
}
