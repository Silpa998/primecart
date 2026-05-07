<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id', 'product_variation_id'];

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    public function variation() {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}
