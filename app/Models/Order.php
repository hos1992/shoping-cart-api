<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'session_id',
        'user_id',
        'username',
        'email',
        'address',
        'shipping_method',
        'payment_method',
        'coupon',
        'final_total',
        'status',
    ];

    protected $appends = [
        'status_txt',
        'shipping_method_txt',
        'payment_method_txt',
    ];

    public function products()
    {

        return $this->belongsToMany('App\Models\Product', 'orders_products', 'order_id', 'product_id')->withPivot('quantity', 'product_final_price');

    }

    public function getStatusTxtAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
                break;

            case 1:
                return 'Processing';
                break;

            case 2:
                return 'Shipping';
                break;

            case 3:
                return 'Delivered';
                break;

            case 4:
                return 'Returned';
                break;
        }
    }

    public function getShippingMethodTxtAttribute()
    {
        switch ($this->shipping_method) {
            case 1:
                return 'Pick up from the store';
                break;

            case 2:
                return 'Home Delivery';
                break;
        }

    }

    public function getPaymentMethodTxtAttribute()
    {
        switch ($this->payment_method) {
            case 1:
                return 'Pay At Store';
                break;

            case 2:
                return 'Cash On Delivery:';
                break;
        }

    }

}
