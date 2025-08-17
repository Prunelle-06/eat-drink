<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_stand',
        'description_stand',
        'image_stand',
        'statut',
        'user_id',
    ];


    public function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }

}
      
   
    