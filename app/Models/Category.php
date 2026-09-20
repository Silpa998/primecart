<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'slug',
        'description',
        'status',
        'available_variations'
    ];

    protected $casts = [
        'available_variations' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}