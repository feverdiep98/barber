<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table ='devvn_tinhthanhpho'; // chi dinh ten bang neu class khac ten bang;
    protected $primarykey = 'matp';
    protected $fillable = [
        'name_city',
        'type',
    ];
}
