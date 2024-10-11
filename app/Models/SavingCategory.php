<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function saving_transactions()
    {
        return $this->hasMany(SavingTrasaction::class, 'saving_category_id', 'id');
    }
}
