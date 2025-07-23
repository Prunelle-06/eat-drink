<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 
        'nom_stand',
        'description_stand',
        'user_id',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function products()
     {
         return 
         $this->belongsTo(User::class);
    }
        
}
