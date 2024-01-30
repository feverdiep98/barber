<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table ='slots'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'booking_date',
        'booked_slots',
        'available_slots',
        'confirmed',
    ];

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
