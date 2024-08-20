<?php

namespace App\Repositories\LoanCategory;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\LoanCategory;

class LoanCategoryRepositoryImplement extends Eloquent implements LoanCategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(LoanCategory $model)
    {
        $this->model = $model;
    }
    public function getLoanCategory()
    {
        return $this->model->all();
    }
    public function getLoanCategoryById($id)
    {
        return $this->model->find($id);
    }
    public function createLoanCategory($data)
    {
        return $this->model->create($data);
    }
    public function updateLoanCategory($id, $data)
    {
        return $this->model->find($id)->update($data);
    }
    public function deleteLoanCategory($id)
    {
        return $this->model->find($id)->delete();
    }
}
