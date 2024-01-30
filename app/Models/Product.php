<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='product'; // chi dinh ten bang neu class khac ten bang;
    protected $casts = [
        'gallery' => 'json',
    ];
    public $fillable = [
        'name',
        'slug',
        'price',
        'discount_price',
        'description',
        'short_description',
        'information',
        'qty' ,
        'shipping',
        'weight',
        'status' ,
        'image_url',
        'gallery',
        'product_category_id',
        'brand_product_id',
    ];
    public function category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id')->withTrashed();
    }
    public function brand(){
        return $this->belongsTo(BrandProduct::class, 'brand_product_id')->withTrashed();
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
