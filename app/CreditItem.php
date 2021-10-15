<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditItem extends Model
{
    //public $timestamps = false;

    protected $fillable = [
        'credit_id',
        'receipt_id'
    ];

    public function credit() {
        return $this->belongsTo('App\Credit');
    }

    public function receipt() {
        return $this->belongsTo('App\Receipt');
    }

}
