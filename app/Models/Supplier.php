<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "suppliers";
    
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'is_wa_same',
        'whatsapp_no',
        'billing_address',
        'billing_landmark',
        'billing_state',
        'billing_city',
        'billing_pin',
        'billing_country',
        'shipping_address',
        'shipping_landmark',
        'shipping_state',
        'shipping_city',
        'shipping_pin',
        'shipping_country',
        'is_billing_shipping_same',
        'gst_number',
        'gst_file',
        'credit_limit',
        'credit_days',
        'status',
    ];
}

