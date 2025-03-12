<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CataloguePageItem extends Model
{
    protected $table = "catalogue_page_items";
    protected $fillable = [
        'catalogue_id', 
        'page_id', 
        'catalog_item'
    ];
}
