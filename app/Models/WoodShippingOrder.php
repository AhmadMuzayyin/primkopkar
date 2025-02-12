<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoodShippingOrder extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function wood()
    {
        return $this->belongsTo(Wood::class);
    }
}
