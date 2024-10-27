<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'allow_changes',
        'last_seen',
        'last_login',
        'address',
        'area',
        'city',
        'country',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Usually the ID of the Admin
    }

    public function getAuthPassword()
    {
        return $this->password; // Return the password attribute
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Return the remember token
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Set the remember token
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Specify the remember token column name
    }

    public function getAuthIdentifierName()
    {
        return 'id'; // The identifier column name, usually 'id'
    }

    public function stock_purchase()
    {
        return $this->belongsTo(StockPurchase::class);
    }
}
