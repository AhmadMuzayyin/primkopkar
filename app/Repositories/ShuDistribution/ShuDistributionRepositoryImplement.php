<?php

namespace App\Repositories\ShuDistribution;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\ShuDistribution;

class ShuDistributionRepositoryImplement extends Eloquent implements ShuDistributionRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ShuDistribution $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
