<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'name',
        'price',
        'category_id',
        'brand_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function order_payment_methods()
    {
        return $this->hasMany(OrderPaymentMethod::class, 'order_id', 'id');
    }
}
