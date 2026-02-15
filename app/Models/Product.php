<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product_image;

class Product extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'name', 'description', 'price', 'discount', 'stock',
        'image', 'weight', 'dimensions', 'warranty', 'rating',
        'brand_id', 'category_id', 'status', 'featured'
    ];

    // Relationship with Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relationship with Categoryy
    public function category()
    {
        return $this->belongsTo(Categoryy::class, 'category_id');
    }

    public function images()
{
    return $this->hasMany(Product_image::class);
}

}
