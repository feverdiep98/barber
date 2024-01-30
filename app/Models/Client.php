<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table ='clients'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'id',
        'name',
        'email',
        'phone',
    ];

    public function booking(){
        return $this->hasOne(Booking::class);
    }
}
