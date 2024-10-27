<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'trx_id',
        'amount',
        'currency',
        'payer_id',
        'gateway_name',
        'email',
        'status',
        'payment_unique_id',
        'payment_order_id',
    ];

    // Define the relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'payment_id');
    }
}
