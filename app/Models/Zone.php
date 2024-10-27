<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';

    protected $fillable = [
        'name',
        'status',
    ];

    // relation with product stock
    public function stock()
    {
        return $this->belongsTo(ProductStock::class);
    }
}
