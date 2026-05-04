<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductVariation;



class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'product_id',
        'product_variation_id', 
        'selected_size',        
        'selected_color',               
        'selected_variant',     
        'quantity',

    
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }
}





