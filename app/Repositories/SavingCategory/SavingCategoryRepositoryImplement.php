<?php

namespace App\Repositories\SavingCategory;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\SavingCategory;

class SavingCategoryRepositoryImplement extends Eloquent implements SavingCategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(SavingCategory $model)
    {
        $this->model = $model;
    }
    public function getSavingCategory()
    {
        return $this->model->all();
    }
    public function getSavingCategoryById($Id)
    {
        return $this->model->where('id', $Id)->get();
    }
    public function createSavingCategory($data)
    {
        return $this->model->create($data);
    }
    public function updateSavingCategory($id, $data)
    {
        return $this->model->find($id)->update($data);
    }
    public function deleteSavingCategory($id)
    {
        return $this->model->find($id)->delete();
    }
}
