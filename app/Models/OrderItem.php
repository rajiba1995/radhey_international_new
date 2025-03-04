<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
   
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'catalogue_id',
        'cat_page_number',
        'product_id',
        'collection',
        'fabrics',
        'category',
        'sub_category',
        'product_name',
        'total_price',
        'piece_price',
        'quantity',
    ];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class, 'catalogue_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
   
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collection', 'id');
    }

    public function collectionType()
    {
        return $this->belongsTo(Collection::class, 'collection', 'id');
    }

    public function measurements()
    {
        return $this->hasMany(OrderMeasurement::class);
    }
    

    //     public function collection()
    // {
    //     return $this->belongsTo(Collection::class, 'collection','id');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category','id');
    }
    public function fabric()
    {
        return $this->belongsTo(Fabric::class, 'fabrics','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
