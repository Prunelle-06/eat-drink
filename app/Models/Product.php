<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'nom_produit',
        'description',
        'prix',
        'photo',
        'stand_id',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class)
                    ->through('stand');
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

       
}
