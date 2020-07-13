<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'product_final_price',
    ];

    public function product_details(){
        return $this->belongsTo(Product::class, 'product_id');
    }

}
