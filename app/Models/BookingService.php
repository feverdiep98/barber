<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='booking_service'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'name',
        'status',
    ];
    public function list(){
        return $this->hasMany(Booking::class);
    }
}
