<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'customer';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'currency_id',
        'avatar',
        'last_seen',
        'status',
        'code',
        'latitude',
        'provider_id',
        'provider_name',
        'longitude'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation with currency
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    // Relation with user_phones
    public function phone()
    {
        return $this->hasMany(UserPhone::class);
    }

    // Relation with user_address
    public function address()
    {
        return $this->hasMany(UserAddress::class);
    }

    // Relation with Wallet
    public function wallet()
    {
        return $this->belongsTo(UserWallet::class);
    }

    // Relation with question
    public function question()
    {
        return $this->hasMany(ProductQuestion::class);  
    }

    // Relation with cart
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    // Relation with review
    public function review() 
    {
        return $this->hasMany(Reviews::class);
    }
}
