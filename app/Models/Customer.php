<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customers';

    protected $fillable = [
        'name_with_initial',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'password_plain',
    ];
}
