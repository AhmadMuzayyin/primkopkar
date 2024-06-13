<?php

namespace App\Repositories\ProductTransaction;

use App\Models\ProductTransaction;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductTransactionRepositoryImplement extends Eloquent implements ProductTransactionRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     *
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(ProductTransaction $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
