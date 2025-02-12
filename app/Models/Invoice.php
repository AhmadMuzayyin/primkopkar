<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function woodShippingOrder()
    {
        return $this->belongsTo(WoodShippingOrder::class, 'wood_shipping_order_id');
    }
}
