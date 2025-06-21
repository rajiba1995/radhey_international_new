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
}
