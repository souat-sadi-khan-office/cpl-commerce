<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'discount',
    ];

    public function customer()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'coupon_id');
    }
}
