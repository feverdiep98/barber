<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table ='holidays'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'date',
        'name',
    ];
}
