<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeasurement extends Model
{
    use HasFactory;

    protected $table = "order_measurements";
    protected $fillable = [
        'order_item_id', 'measurement_name', 'measurement_value', 'created_at', 'updated_at'
    ];
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
    public function measurement()
{
    return $this->belongsTo(Measurement::class, 'measurement_name', 'title'); // Ensure you use the correct foreign key
}

}
