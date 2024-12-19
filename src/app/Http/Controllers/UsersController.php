<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function mypage()
    {
        $user = User::find(Auth::id());
        $reservations = Reservation::with('shop')->orderBy('reservation_date','asc')->orderBy('reservation_time', 'asc')->where('user_id', $user['id'])->get();

        return view('mypage', compact('user','reservations'));
    }
}
