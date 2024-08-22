<?php

namespace App\Repositories\Loan;

use LaravelEasyRepository\Repository;

interface LoanRepository extends Repository
{

    public function getLoanByMemberId($memberId);
    public function getLoanByLoanCategoryId($loanCategoryId);
    public function getLoans();
    public function createLoans($data);
    public function updateLoans($data, $id);
    public function deleteLoans($id);
}
