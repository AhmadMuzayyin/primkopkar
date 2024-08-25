<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    public function loan_category(): BelongsTo
    {
        return $this->belongsTo(LoanCategory::class);
    }
    public function loan_payment(): HasMany
    {
        return $this->hasMany(LoanPayment::class);
    }
}
