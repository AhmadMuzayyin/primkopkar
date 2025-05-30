<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function loans()
    {
        return $this->hasMany(Loan::class, 'loan_category_id', 'id');
    }
}
