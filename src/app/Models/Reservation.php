<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'shop_id',
        'reservation_date',
        'reservation_time',
        'number',
        'user_id',
    ];

    public static function postReservation($request, $shop_id)
    {
        $param = [
            "shop_id" => $shop_id,
            "reservation_date" => $request->date,
            "reservation_time" => $request->time,
            "number" => $request->number,
            "user_id" => $request->user_id,
        ];
        $reservation = Reservation::create($param);
        return $reservation;
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
