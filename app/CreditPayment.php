<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    protected $fillable = [
        'credit_id',
        'user_id',
        'amount'
    ];

    public function credit() {
        return $this->belongsTo('App\Credit');
    }

}
