<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'warehouse_id'
    ];

    public function warehouse() {
        
        $this->belongsTo('App\Warehouse');
    }

    public function products() {
        $this->hasMany('App\Product');
    }
}
