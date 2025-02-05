<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'city_id',
        'name',
        'status',
    ];

    // Relationship with City
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
