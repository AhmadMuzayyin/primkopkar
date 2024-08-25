<?php

namespace App\Repositories\LoanPayment;

use LaravelEasyRepository\Repository;

interface LoanPaymentRepository extends Repository
{
    public function getLoanPayments();
    public function createLoanPayments($data);
}
