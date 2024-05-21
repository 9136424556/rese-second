@extends('layouts.app')

@section('main')

  
<div class="detail-shop-class">
   <div class="detail-shop-introduction">
      <h1>{{  $shops->shop_name }}</h1>
      <img  src= "{{ $shops->image }}" alt="" width="100%">
        <div class="detail-place-category">
           <p class="shop-tag-detail">#{{ $shops->place }}</p>
            <p class="shop-tag-detail">#{{ $shops->category }}</p>
       </div>
        <p class="shop-introduction">{{ $shops->introduction}}</p>
   </div>
   
  
  <div class="detail-form">

    <form action="/detail" method="post">
      @csrf
    
        <h2 class="detail-header">予約</h2>
        
          <div class="reservation-input-list">
             <input class="date" type="date" name="date" list="daylist" min="" value="">
          </div>
         
         <div class="reservation-input-list">
             <input class="detail-time" type="time" list="data-list" step="1800" name="time" placeholder="08012349876" value="">
         </div>
         <datalist id="data-list">
            <option value="18:00"></option>
            <option value="18:30"></option>
            <option value="19:00"></option>
            <option value="19:30"></option>
            <option value="20:00"></option>
            <option value="20:30"></option>
        </datalist>

        <div class="reservation-input-list"><input class="member-count" type="number" min="1" name="member" value=""></div>
     

       <table class="detail-confirm">
         <tr>
            <th>Shop</th>
            <td class="reservation-shop-td">{{ $shops->shop_name }}</td>
         </tr>

         <tr>
            <th>Date</th>
            <td class="reservation-shop-td">{{ session('date')}}</td>
         </tr>
         <tr>
            <th>Time</th>
            <td class="reservation-shop-td">{{ session('time')}}</td>
         </tr>
         <tr>
            <th>Number</th>
            <td class="reservation-shop-td"></td>
         </tr>
           
       </table>
                            
                    
           <div class="submit-button">
             <input type="hidden" id="shop_id" name="shop_id" value="{{ $shops->id }}">
              <input type="hidden" id="user_id" name="user_id" value="{{ $users }}">
              <input class="submit" type="submit" value="予約する">
             
          </div>    
      </form>
    </div>
</div>

@endsection