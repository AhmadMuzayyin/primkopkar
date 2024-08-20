<?php

namespace App\Repositories\LoanCategory;

use LaravelEasyRepository\Repository;

interface LoanCategoryRepository extends Repository
{

    public function getLoanCategory();
    public function getLoanCategoryById($id);
    public function createLoanCategory($data);
    public function updateLoanCategory($id, $data);
    public function deleteLoanCategory($id);
}
