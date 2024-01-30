<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;

    protected $table ='devvn_xaphuongthitran'; // chi dinh ten bang neu class khac ten bang;
    protected $primarykey = 'xaid';
    protected $fillable = [
        'name_xaphuong',
        'type',
        'maqh',
    ];
}
