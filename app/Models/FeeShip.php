<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeShip extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'feeshipping'; // chi dinh ten bang neu class khac ten bang;
    protected $primarykey = 'fee_id';
    protected $fillable = [
        'fee_matp',
        'fee_maqh',
        'fee_xaid',
        'shipping_fee',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'fee_matp', 'matp');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'fee_maqh', 'maqh');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'fee_xaid', 'xaid');
    }
}
