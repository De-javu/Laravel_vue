<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contac extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'vatar',
        'privacity',
        'user_id',
    ];

}