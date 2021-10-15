<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptItems extends Model
{
   // public $timestamps = false;

    protected $fillable = [
        'receipt_id',
        'product_id',
        'product_price',
        'quantity',
        'discount_allowed'
    ];

    public function receipt() {
        return $this->belongsTo('App\Receipt');
    }

    public function product() {
        return $this->belongsTo('App\Product');
    }

}
