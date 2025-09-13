<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom_complet',
        'email',
        'type',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function stand() {
        return $this->hasOne(Stand::class);
    }

    public function favoriteStands() {
        
        return $this->belongsToMany(Stand::class, 'stand_favorites')
                    ->withTimestamps();
    }

    // Vérifier si un stand est en favori
    public function hasFavorited($standId)
    {
        return $this->favoriteStands()->where('stand_id', $standId)->exists();
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Stand::class);
    }

    public function isExposant() {
        return $this->type === 'exposant';
    }

    public function isVisiteur() {
        return $this->type === 'visiteur';
    }

    public function isAdmin() {
        return $this->type === 'admin';
    }

}
