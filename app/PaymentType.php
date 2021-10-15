<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    //public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    public function receipt() {
        return $this->belongsTo('App\Receipt');
    }
}
