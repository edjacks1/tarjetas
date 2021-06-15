<?php

namespace App\Models;

use App\Traits\GenerarUuid;
use Illuminate\Database\Eloquent\Model;

class User extends Model{

    use GenerarUuid;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'phone_number', 
        'email', 
        'uuid',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}