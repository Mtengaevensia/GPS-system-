<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    //
    protected $fillable = [
        'name',
        'license_number',
        'phone',
        'email',
        'status',
        'address',
        'joined_date'
    ];
    
}
