<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    protected $table = "catalogues";
    protected $fillable = [
        'catalogue_title_id',
        'page_number',
        'image'	
    ];

    public function catalogueTitle()
    {
        return $this->belongsTo(CatalogueTitle::class, 'catalogue_title_id');
    }
}
