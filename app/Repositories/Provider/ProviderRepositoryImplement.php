<?php

namespace App\Repositories\Provider;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class ProviderRepositoryImplement extends Eloquent implements ProviderRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Provider $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function getAllData()
    {
        return $this->model->all();
    }
    public function storeData($data)
    {
        try {
            return DB::transaction(function () use ($data) {
                return $this->model->create($data);
            });
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function updateData($data, $id)
    {
        try {
            return $this->model->findOrFail($id)->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteData($id)
    {
        try {
            return $this->model->findOrFail($id)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
