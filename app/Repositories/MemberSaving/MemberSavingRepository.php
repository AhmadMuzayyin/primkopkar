<?php

namespace App\Repositories\MemberSaving;

use LaravelEasyRepository\Repository;

interface MemberSavingRepository extends Repository
{

    public function getMemberSavings();
    public function getMemberSavingById($id);
    public function getMemberSavingByMember($id, $category_id);
    public function createMemberSaving($data);
    public function updateMemberSaving($data, $id);
    public function deleteMemberSaving($id);
}
