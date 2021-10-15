<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    //public $timestamps = false;

    protected $fillable = [

        'customer_id',
        'total',
        'paid_total'

    ];

    public function items() {
        return $this->hasMany('App\CreditItem');
    }

    public function payments() {
        return $this->hasMany('App\CreditPayment');
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    public function receipts() {
        return $this->belongsToMany('App\Receipt', 'credit_items');
    }

}
