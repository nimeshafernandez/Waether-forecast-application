<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'location'
    ];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function categories() {
        return $this->hasMany('App\Category');
    }

    public function brands() {
        return $this->hasMany('App\Brand');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function grns() {
        return $this->hasMany('App\Grn');
    }
}
