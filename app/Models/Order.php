<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'unique_id',
        'payment_id',
        'user_id',
        'order_amount',
        'tax_amount',
        'discount_amount',
        'final_amount',
        'currency_id',
        'payment_status',
        'status',
        'is_delivered',
        'is_cod',
        'is_refund_requested',
    ];

    // Define the relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function details()
    {
        return $this->hasOne(OrderDetail::class, 'order_id');
    }
}
