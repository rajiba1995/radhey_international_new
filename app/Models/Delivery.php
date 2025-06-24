<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = "deliveries";
    protected $fillable = [
        'order_id',
        'order_item_id',
        'delivery_type',
        'product_id',
        'fabric_id',
        'delivered_quantity',
        'unit',
        'delivered_by',
        'delivered_at'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function orderitem(){
        return $this->belongTo(OrderItem::class,'order_item_id','id');
    }
}
