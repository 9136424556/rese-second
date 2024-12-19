<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Number;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;

class ReservationsController extends Controller
{
    public function confirm(Request $request)
    {
       $sendId = $request->only('sendId');

       return redirect()->route('detail', ['shop_id' => $sendId['sendId'] ])->withInput();
    }

    public function store(ReservationRequest $request)
    {
        
           $input = new Reservation();
           $input->reservation_date = $request->date;
           $input->reservation_time = $request->time;
           $input->number = $request->number;
           $input->user_id = Auth::id();
           $input->shop_id = $request->shop_id;
         
          
           $input->save();
               
          return redirect('/done');
        
    }
    public function done()
    {
        return view('done');
    }
    public function delete($reservation_id)
    {
        Reservation::find($reservation_id)->delete();
       
        return redirect('mypage');
    }
//予約内容変更ページ
    public function edit($reservation_id)
    {
        $reservation = Reservation::with('shop')->find($reservation_id);
        $times = Time::all();
        $numbers = Number::all();        //↓ 左からY(西暦の4桁)、m(月)、d(2桁の日付)
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        

        return view('edit', compact('reservation','times','numbers','tomorrow'));
    }

    public function editconfirm(Request $request)
    {
        $sendId = $request->only('sendId');

        return redirect()->route('edit',['reservation_id' => $sendId['sendId'] ])->withInput();
    }
    public function reservationEdit(ReservationRequest $request)
    {
        $edit = $request->only('date','time','number');
        Reservation::find($request->id)->update($edit);

        return view('edit-complete');
    }
   
}
