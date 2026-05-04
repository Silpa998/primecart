<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected  $fillable = [
        'product_id',
        'type',
        'size',
        'variant',
        'color', 
        'image',
        'price',
        'stock',
        'sku',
    ];

    protected $casts = [
        'size_type' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
