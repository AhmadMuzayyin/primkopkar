<?php

namespace App\Repositories\Saving;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\SavingTrasaction;

class SavingRepositoryImplement extends Eloquent implements SavingRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(SavingTrasaction $model)
    {
        $this->model = $model;
    }

    public function getSavings()
    {
        return $this->model->with('member', 'savingCategory')->get();
    }
    public function getSavingsByType($type)
    {
        return $this->model->with('member', 'savingCategory')->where('transaction_type', $type)->get();
    }
    public function getSavingByMember($member_id, $type)
    {
        return $this->model->with('member', 'savingCategory')->where('member_id', $member_id)->where('saving_category_id', $type)->get();
    }
    public function createSaving($data)
    {
        return $this->model->create($data);
    }
    public function updateSaving($data, $saving_id, $member_id)
    {
        return $this->model->where('id', $saving_id)->where('member_id', $member_id)->update($data);
    }
}
