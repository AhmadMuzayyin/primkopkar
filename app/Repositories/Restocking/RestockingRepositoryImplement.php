<?php

namespace App\Repositories\Restocking;

use Exception;
use App\Models\Restocking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Implementations\Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class RestockingRepositoryImplement extends Eloquent implements RestockingRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Restocking $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        try {
            return Restocking::all();
        } catch (QueryException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        }
    }

    public function findById(int $id): ?Restocking
    {
        try {
            $restocking = Restocking::findOrFail($id);
            return $restocking;
        } catch (ModelNotFoundException $e) {
            throw new Exception("Restocking not found", 404);
        }
    }

    public function createData(array $data)
    {
        DB::beginTransaction();
        try {
            $restocking = Restocking::create($data);
            DB::commit();
            return $restocking;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception("Failed to create restocking: " . $e->getMessage(), 500);
        }
    }

    public function updateData(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $restocking = Restocking::findOrFail($id);
            $restocking->update($data);
            DB::commit();
            return true;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new Exception("Restocking not found", 404);
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception("Failed to update restocking: " . $e->getMessage(), 500);
        }
    }

    public function deleteData(int $id)
    {
        DB::beginTransaction();
        try {
            $restocking = Restocking::findOrFail($id);
            $restocking->delete();
            DB::commit();
            return true;
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new Exception("Restocking not found", 404);
        } catch (QueryException $e) {
            DB::rollBack();
            throw new Exception("Failed to delete restocking: " . $e->getMessage(), 500);
        }
    }
}
