<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Variation extends Model
{
    protected $fillable = [
        'variation_name',
        'slug',
        'status'
    ];

    protected static function booted()
    {
        static::creating(function ($variation) {
            $variation->slug = Str::slug($variation->variation_name);
        });
    }
}