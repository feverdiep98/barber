<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgProduct extends Model
{
    use HasFactory;
    protected $table ='product_image';
    protected $fillable = ['product_id','image_url'];
}
