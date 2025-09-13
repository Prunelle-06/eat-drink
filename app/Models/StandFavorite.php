<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StandFavorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'stand_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
}
