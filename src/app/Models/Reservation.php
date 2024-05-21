<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'reservation_datetime',
        'number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class,'id');
    }
}
