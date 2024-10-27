<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_ids', // Assuming this is a string of IDs or JSON
        'details',     // Assuming this is a JSON
        'notes',
        'shipping_method',
        'shipping_address',
        'billing_address',
        'phone',
        'email'
    ];

    // Define the relationships

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
