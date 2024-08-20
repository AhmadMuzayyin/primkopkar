<?php

namespace App\Repositories\Loan;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Loan;

class LoanRepositoryImplement extends Eloquent implements LoanRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Loan $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
