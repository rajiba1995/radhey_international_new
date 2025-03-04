<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    protected $table = "business_types";
    protected $fillable = ['title'];
    // public function products()  
    // {
    //     return $this->belongsToMany(Product::class, 'product_fabrics', 'fabric_id', 'product_id');
    // }

    public function users()
    {
        return $this->hasMany(User::class, 'business_type_id');
    }
}
