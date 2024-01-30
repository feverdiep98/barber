<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='brand_product'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'name',
        'slug',
        'status',
    ];
    public function products(){
        return $this->hasMany(Product::class, 'brand_product_id')->withTrashed();
    }
}
