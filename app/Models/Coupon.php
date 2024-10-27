<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'coupon_code',
        'minimum_shipping_amount',
        'discount_amount',
        'discount_type',
        'maximum_discount_amount',
        'start_date',
        'end_date',
        'status'
    ];
}
