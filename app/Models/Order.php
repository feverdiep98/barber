<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order';
    protected $dates = ['newDeliveryDate'];
    // const STATUS = [
    //     'pending' => 'pending',
    //     'success' => 'success',
    //     'cancel' => 'cancel',
    //     'shipping' => 'shipping',
    //     'fail' => 'fail',
    // ];

    const STATUS_PENDING = 'Pending';
    const STATUS_SUCCESS = 'Success';
    const STATUS_CANCEL = 'Cancel';
    const STATUS_SHIPPING = 'Shipping';
    const STATUS_FAIL = 'Fail';

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'user_id',
        'address',
        'town',
        'note',
        'status',
        'payment_method',
        'subtotal',
        'total',
        'delivery_date',
        'email',
        'shipping_fee',
        'gender',
    ];

    public function order_payment_methods()
    {
        return $this->hasMany(OrderPaymentMethod::class, 'order_id', 'id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function calculateTotalQuantity(){
        return $this->order_items->sum('qty');
    }
    public function product(){
        return $this->belongsTo(Product::class,'id');
    }
}
