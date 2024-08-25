<?php

namespace App\Repositories\Saving;

use LaravelEasyRepository\Repository;

interface SavingRepository extends Repository
{
    public function getSavings();
    public function getSavingsByType($type);
    public function getSavingByMember($member_id, $type);
    public function createSaving($data);
    public function updateSaving($data, $saving_id, $member_id);
}
