<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'user_id',
        'warehouse_id',
        'payment_type_id',
        'total',
        'discount'
    ];

    public function paymentTypes() {
        return $this->hasOne('App\PaymentType');
    }

    public function items() {
        return $this->hasMany('App\ReceiptItems');
    }

    public function products() {
        return $this->belongsToMany('App\Product', 'receipt_items');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

}
