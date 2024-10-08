<?php

namespace App\Repositories\SavingTransaction;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\SavingTransaction;

class SavingTransactionRepositoryImplement extends Eloquent implements SavingTransactionRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(SavingTransaction $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
