<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'business_type',
        'order_number',
        'customer_name',
        'customer_email',
        'billing_address',
        'shipping_address',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'last_payment_date',
        'payment_mode',
        'status',
        'business_type',
        'created_by' ,
        'team_lead_id',
        'country_code_alt_1',
        'alternative_phone_number_1',
        'country_code_alt_2',
        'alternative_phone_number_2',
        'country_code_whatsapp',
        'country_code_phone',
        'source',
        'reference',
        'ht_amount',
        'tva_amount',
        'ca_amount',
        'due_date',
        'invoice_date',
        'invoice_type',
        'total_product_amount',
        'air_mail'
    ];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function measurements()
    {
        return $this->hasMany(OrderMeasurement::class);
    }
    public function measurement()
    {
        return $this->belongsTo(Measurement::class, 'measurement_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function packingslip()
    {
        return $this->hasOne(PackingSlip::class, 'order_id', 'id');
    }
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type');
    }


    protected $status_classes = [
        "Confirmed"          => ["Confirmed", "success"],
        "Mark As Received"   => ["Mark As Received", "success"],
        "Pending"            => ["Pending", "warning"],
        "In Production"      => ["In Production", "primary"],
        "Ready for Delivery" => ["Ready for Delivery", "info"],
        "Shipped"            => ["Shipped", "secondary"],
        "Delivered"          => ["Delivered", "success"],
        "Cancelled"          => ["Cancelled", "danger"],
        "Returned"           => ["Returned", "dark"],
        "production_delivered"=> ["Production Delivered", "warning"],
        "received_after_production_delivered"=> ["Mark As Received After Production", "info"],
        "Approved"                => ["Approved", "success"],
        // "Mark As Received"        => ["Mark As Received", "success"],
        "Approval Pending"        => ["Approval Pending", "warning"],
        "Received at Production"  => ["Received at Production", "primary"],
        "Ready for Delivery"      => ["Ready for Delivery", "info"],
        "Partial Delivered"       => ["Partial Delivered", "secondary"],
        "Fully Delivered"         => ["Fully Delivered", "success"],
        "Cancelled"               => ["Cancelled", "danger"],
        "Returned"                => ["Returned", "dark"]
    ];

    // Accessor to get status label
    public function getStatusLabelAttribute()
    {
        $order_status = $this->attributes['status'] ?? 'Returned'; // Default to "Returned"
        return $this->status_classes[$order_status][0] ?? "Unknown"; // Fallback to "Unknown"
    }

    // Accessor to get status class
    public function getStatusClassAttribute()
    {
        $order_status = $this->attributes['status'] ?? 'Returned'; // Default to "Returned"
        return $this->status_classes[$order_status][1] ?? "muted"; // Default class if not found
    }
    // In the Order model

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id', 'id');
    }






}
