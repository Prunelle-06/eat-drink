<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'stand_id',
        'order_number',
        'total_amount',
        'status',
        'pickup_code', 
        'code_generated_at',   
        'confirmed_at',
        'ready_at',
        'delivered_at'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeConfirmed()
    {
        return $this->status === 'pending';
    }

    // Scopes
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeForStand($query, $standId)
    {
        return $query->where('stand_id', $standId);
    }

    public function scopeForClient($query, $userId)
    {
        return $query->where('orders.user_id', $userId)
          ->select('orders.*')
          ->join('users', 'orders.user_id', '=', 'users.id')
          ->where('users.type', 'visiteur');
    }

    public static function generateOrderNumber()
    {
        do {
            $number = 'CMD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $number)->exists());
        
        return $number;
    }

    public static function generateUniqueCode()
    {
        do {
            $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('pickup_code', $code)
                     ->where('code_used', false)
                     ->exists());
        
        return $code;
    }
}
