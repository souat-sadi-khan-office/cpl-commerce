<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'trx_currency_code',
        'trx_amount',
    ];

    // Define the relationships

    public function wallet()
    {
        return $this->belongsTo(UserWallet::class, 'wallet_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, UserWallet::class, 'id', 'wallet_id', 'wallet_id', 'id');
    }
}
