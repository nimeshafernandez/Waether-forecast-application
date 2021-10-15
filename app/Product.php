<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        'name',
        'search_term',
        'code',
        'selling_price',
        'reorder_stock',
        'active',
        'custom_scale',
        'category_id',
        'brand_id',
        'warehouse_id'
    ];

    public function brand() {
        return $this->belongsTo('App\Brand');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function warehouse() {
        return $this->belongsTo('App\Warehouse');
    }

    public function barcodes() {
        return $this->hasMany('App\Barcode');
    }

    public function stock() {
        return $this->hasOne('App\Stock');
    }
}
