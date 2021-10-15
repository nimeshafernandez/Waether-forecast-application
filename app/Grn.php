<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    protected $fillable = [
        'supplier_id',
        'warehouse_id',
        'user_id',
        'invoice',
    ];

    public function grnlist() {
        return $this->hasMany('App\GrnList');
    }

    public function warehouse() {
        return $this->belongsTo('App\Warehouse');
    }
}
