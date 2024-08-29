<?php

namespace App\Repositories\Loan;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Loan;

class LoanRepositoryImplement extends Eloquent implements LoanRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Loan $model)
    {
        $this->model = $model;
    }
    public function getLoanByMemberId($member_id)
    {
        return $this->model->where('member_id', $member_id)->get();
    }
    public function getLoanActive($member_id, $loan_category_id)
    {
        return $this->model->where('member_id', $member_id)->where('loan_category_id', $loan_category_id)->where('status', 'Belum Lunas')->first();
    }
    public function getLoanByLoanCategoryId($loan_category_id)
    {
        return $this->model->where('loan_category_id', $loan_category_id)->get();
    }
    public function getLoans()
    {
        return $this->model->all();
    }
    public function createLoans($data)
    {
        return $this->model->create($data);
    }
    public function updateLoans($data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }
    public function deleteLoans($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
