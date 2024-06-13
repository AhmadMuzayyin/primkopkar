<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findById($id)
    {
        return $this->model->whereId($id)->first();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function storeData($request)
    {
        try {
            $this->model->create($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateData($request, $id)
    {
        try {
            $this->model->whereId($id)->update($request->all());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $this->model->whereId($id)->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
