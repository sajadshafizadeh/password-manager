<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passwords extends Model
{
    protected $fillable = [
        'username', 'type_id',
    ];
}
