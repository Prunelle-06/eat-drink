<?php

namespace App\Models;


use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stand extends Model implements CanVisit
{
    use HasFactory;
    use HasVisits;

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

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function favoritedBy() {
    
        return $this->belongsToMany(User::class, 'stand_favorites')
                    ->withTimestamps();
    }

    // Compter le nombre de favoris
    public function getFavoritesCountAttribute()
    {
        return $this->favoritedBy()->count();
    }   

    public function isApproved()
    {
        return $this->statut === 'approuve';
    } 

}
      
   
    