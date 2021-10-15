<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    
    protected $fillable =[
        'product_id',
        'barcode'
    ];

    public function product() {
        return $this->belongsTo('App\Product');
    }
}
