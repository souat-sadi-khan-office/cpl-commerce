<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'country_id',
        'name',
        'symbol',
        'exchange_rate',
        'code',
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
