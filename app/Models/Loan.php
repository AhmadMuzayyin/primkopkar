<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function loan_category()
    {
        return $this->belongsTo(LoanCategory::class);
    }
}
