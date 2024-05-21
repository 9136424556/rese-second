<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::orderBy('id' )->get();  

        return view('index', compact('shops'));
    }
     public function show($shop_id)
    {
      
       $shops = Shop::find($shop_id);
       
      $users = Auth::id();
       
        return view('detail', compact('shops','users'));
    }
    public function create(Request $request)
    {
       
        return view('done');
    }
    public function store(Request $request)
    {
        
        $reserv = new Reservation();
        $reserv->reservation_datetime.$reserv->reservation_datetime = $request->date.$request->time;
        $reserv->number = $request->member;
        $reserv->shop_id = $request->shop_id;
        $reserv->user_id = $request->user_id;
       
    
        $reserv->save();
     
      
        return redirect('/done');
    }
    public function done()
    {
        return view('done');
    }

    public function menu()
    {
      

        return view('menu');
    }

   
    
    public function mypage()
    {
        $shops = Reservation::orderby('id')->get();
        $users = Auth::user();

        return view('mypage',compact('shops','users'));
    }
    
    public function userdataPage(Request $request): View
    {
        $date = $request->date;
        $time = $request->time;
        $member = $request->member;

        $data = compact('date', 'time','member');
        session($data);

        return view('detail', $data);
    }
    public function confirmdataPage(Request $request): view
   {
        $session = $request->session()->all();
        $date =$request->date;
        $time = $request->time;
        $member = $request->member;

        $data = compact(
            'date',
            'time',
            'member',
        );
        session($data);

        return view('detail', $data);
   }
}
