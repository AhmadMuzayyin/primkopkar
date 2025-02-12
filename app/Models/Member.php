<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function product_transaction()
    {
        return $this->hasMany(ProductTransaction::class);
    }
    public function member_saving()
    {
        return $this->hasOne(MemberSaving::class);
    }
}
