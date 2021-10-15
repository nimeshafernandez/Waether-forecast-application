<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'nic_no',
        'address',
        'credit_id',
        'phone'
    ];

    public function credit() {
        return $this->hasOne('App\Credit');
    }

}
