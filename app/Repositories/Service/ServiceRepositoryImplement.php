<?php

namespace App\Repositories\Service;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Service;

class ServiceRepositoryImplement extends Eloquent implements ServiceRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeData(array $data)
    {
        return $this->model->create($data);
    }

    public function updateData(array $data, $id)
    {
        try {
            return $this->model->findOrFail($id)->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteData($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
