<?php

namespace App\Repositories\LoanPayment;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\LoanPayment;

class LoanPaymentRepositoryImplement extends Eloquent implements LoanPaymentRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(LoanPayment $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
