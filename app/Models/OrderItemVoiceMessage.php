<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemVoiceMessage extends Model
{
    protected $table = 'order_item_voice_messages';

    protected $fillable = [
        'order_item_id',
        'voices_path',
        'created_at',
        'updated_at',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class,'order_item_id');
    }

}
