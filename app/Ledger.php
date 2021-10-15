<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $fillable = [
        'ledger_types_id',
        'desc',
        'amount'

    ];
    
    public function ledgertype() {
        return $this->hasMany('App\LedgerType');
    }
}
