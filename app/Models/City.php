<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'name',
        'status',
    ];

    // Relationship with Country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relationship with area
    public function area()
    {
        return $this->hasMany(Area::class);
    }

    // Relationship with product stock
    public function stock()
    {
        return $this->belongsTo(ProductStock::class);
    }
}
