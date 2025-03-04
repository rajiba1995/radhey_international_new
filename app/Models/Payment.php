<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = "payments";

    protected $fillable = [
        'stuff_id', 'customer_id', 'admin_id', 'supplier_id', 'expense_id', 'service_slip_id',
        'discount_id', 'payment_for', 'payment_in', 'bank_cash', 'voucher_no', 'payment_date',
        'payment_mode', 'amount', 'chq_utr_no', 'bank_name', 'narration', 'created_from',
        'is_gst', 'created_by', 'updated_by', 'image'
    ];

    // Relationship with the staff (User model where user_type = 0)
    public function staff()
    {
        return $this->belongsTo(User::class, 'stuff_id', 'id')->where('user_type', 0);
    }

    // Relationship with the admin (User model)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // Relationship with the user (if needed for customers or different role users)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    // Relationship with suppliers
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // Relationship with expenses
    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id', 'id');
    }
}
