<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $table = 'changelog';
    protected $fillable = [
        'done_by',
         'purpose', 
         'data_details'
    ];
    
}
