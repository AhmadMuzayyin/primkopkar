<?php

namespace App\Repositories\MemberSaving;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\MemberSaving;

class MemberSavingRepositoryImplement extends Eloquent implements MemberSavingRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(MemberSaving $model)
    {
        $this->model = $model;
    }
    public function getMemberSavings()
    {
        return $this->model->with('member', 'savingCategory')->get();
    }
    public function getMemberSavingById($id)
    {
        return $this->model->with('member', 'savingCategory')->find($id);
    }
    public function getMemberSavingByMember($id, $category_id)
    {
        return $this->model->with('member', 'savingCategory')->where('member_id', $id)->where('saving_category_id', $category_id)->first();
    }
    public function createMemberSaving($data)
    {
        return $this->model->create($data);
    }
    public function updateMemberSaving($data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function deleteMemberSaving($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
