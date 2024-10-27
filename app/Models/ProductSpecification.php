<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'key_id',
        'type_id',
        'attribute_id',
        'key_feature',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function specificationKey()
    {
        return $this->belongsTo(SpecificationKey::class, 'key_id');
    }

    public function specificationKeyType()
    {
        return $this->belongsTo(SpecificationKeyType::class, 'type_id');
    }

    public function specificationKeyTypeAttribute()
    {
        return $this->belongsTo(SpecificationKeyTypeAttribute::class, 'attribute_id');
    }
}
