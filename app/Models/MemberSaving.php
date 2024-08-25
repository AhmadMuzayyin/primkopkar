<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSaving extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function savingCategory()
    {
        return $this->belongsTo(SavingCategory::class);
    }
}
