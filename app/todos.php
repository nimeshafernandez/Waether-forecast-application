<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class todos extends Model
{
    
    protected $fillable =[
        'User_Name',
        'Event_Name',
        'Daily_Task',
        'Date',

    ];
}
