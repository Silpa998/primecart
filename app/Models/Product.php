<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
  
class Product extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'product_name', 'category_id', 'price', 'stock', 'image', 
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function variations()
    { 
        // if product_id is the foreign key in product_variations table, we can omit it as Laravel will automatically use the convention
        return $this->hasMany(ProductVariation::class, 'product_id');
    }
}