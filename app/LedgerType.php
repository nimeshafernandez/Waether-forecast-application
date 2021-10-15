<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LedgerType extends Model
{
    //public $timestamps = false;
    protected $fillable = [
        'type'
    ];

    public function ledger() {
        return $this->belongsTo('App\Ledger');
    }
}
