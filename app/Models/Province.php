<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table ='devvn_quanhuyen'; // chi dinh ten bang neu class khac ten bang;
    protected $primarykey = 'maqh';
    protected $fillable = [
        'name_quanhuyen',
        'type',
        'matp',
    ];
}
