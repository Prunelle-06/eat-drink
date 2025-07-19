<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = [
        'nom_stand',
        'description_stand',
        'user_id',
    ];
}
