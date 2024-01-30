<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='booking'; // chi dinh ten bang neu class khac ten bang;
    public $fillable = [
        'client_id',
        'slot_id',
        'name',
        'email',
        'phone',
        'booking_time',
        'booking_date',
        'type',
        'slot',
        'note',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function services(){
        return $this->belongsTo(BookingService::class, 'type', 'name');
    }
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
