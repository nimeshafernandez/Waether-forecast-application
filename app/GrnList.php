<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrnList extends Model
{
    //public $timestamps = false;

    protected $fillable = [
        'product_id',
        'quantity',
        'unit_cost',
        'exp_date',
        'grn_id'
    ];

    public function grn() {
        return $this->belongsTo('App\Grn');
    }
}
