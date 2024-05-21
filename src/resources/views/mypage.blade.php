@extends('layouts.app')

@section('main')

<div class="mypage-reserv-form">
   @foreach($shops as $shop)
<table class="detail-confirm-mypage">
         <tr>
            <th class="reservation-th">Shop</th>
            <td class="reservation-td">{{ $shop->shop_id }}</td>
         </tr>
         <tr>
            <th class="reservation-th">Date</th>
            <td class="reservation-td">{{ $shop->reservation_datetime }}</td>
         </tr>
         <tr>
            <th class="reservation-th">Time</th>
            <td class="reservation-td"></td>
         </tr>
         <tr>
            <th class="reservation-th">Number</th>
            <td class="reservation-td">{{ $shop->number }}</td>
         </tr>
           
    </table>
</div>
@endforeach
    <h1></h1>
    
    @endsection