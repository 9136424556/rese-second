@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">

@section('main')
<div class="header">
   <!--決済処理-->
   <div class="stripe">
      <form action="{{ route('stripe') }}" method="POST">
         @csrf
         <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
         data-amount="1000"
         data-key="{{ env('STRIPE_KEY') }}"
         data-name="お支払い画面"
         data-label="決済をする"
         data-description="現在はデモ画面です"
         data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
         data-locale="auto"
         data-currency="JPY">
         </script>
      </form>
   </div>
   <!--ログインユーザー名-->
   <div class="user-name">
      <h2 class="login-username">{{ $user->name }}さん</h2>
   </div>
</div>


<div class="mypage-reserv-form">
   <div class="mypage-action1">
      <div class="reserv-title">
          <h2>予約状況</h2>
      </div>
    
     @foreach($user->reservations as $key => $reservation)
     <div class="flex-mypage-1">
      <div class="reserv-items">
         <div class="reserv-logo">
            {{ '予約' . ($key  + 1) }}
         </div>

         <div class="reserv-change">
            <a href="{{ route('edit', ['reservation_id' => $reservation->pivot->id] )}}">
               予約内容を変更する
            </a>
         </div>

         <div class="reserv-delete">
             <form action="{{ route('reserv.delete', ['reservation_id' => $reservation->pivot->id] )}}" method="POST">
             @csrf
               <input type="submit" class="cancel" value="取り消し" onclick='return confirm("予約を取り消しますか？")'>
             </form>
         </div>
      </div>
     
        
         
         <table class="detail-confirm-mypage">
   
         <tr>
            <th class="reservation-th">Shop</th>
            <td class="reservation-td">{{ $reservation->shop_name}}</td>
         </tr>
         <tr>
            <th class="reservation-th">Date</th>
            <td class="reservation-td">{{ $reservation->pivot->reservation_date}}</td>
         </tr>
         <tr>
            <th class="reservation-th">Time</th>
            <td class="reservation-td">{{ $reservation->pivot->reservation_time}}</td>
         </tr>
         <tr>
            <th class="reservation-th">Number</th>
            <td class="reservation-td">{{ $reservation->pivot->number}}</td>
         </tr>  
       </table>
      </div>
     @endforeach
   </div>

 <div class="like">
   <div class="like-title">
      <h2>お気に入り店舗</h2>
   </div>
   
   <div class="likes-shops">
      @foreach($user->likes as $shop)
      <div class="shop-card">
         <img src="{!! $shop->image !!}" alt="" width="100%">
        <h3>{{ $shop->shop_name }}</h3>
        <p>#{{ $shop->area->name}} #{{ $shop->genre->name}}</p>
        <div class="detail-and-like">
         <div class="detail-side">
           <a href="{!! '/detail/' . $shop->id !!}" ><button type="button" class="in-detail">詳しく見る</button></a>
         </div>
         <div class="like-side">
        @if(Auth::check() )
          @if(count($shop->likes) == 0)
          <form action="{{ route('like', ['shop_id' => $shop->id]) }}" method="POST">
           @csrf
           <input class="like-icon" type="image" src="/img/unlike.png"  width="32px" height="32px" alt="いいね">
          </form>
           @else
           <form action="{{ route('unlike', ['shop_id' => $shop->id]) }}" method="POST">
           @csrf
           <input class="like-icon" type="image" src="/img/like.png"  width="32px" height="32px">
          </form>
          @endif
        @endif
        </div>
        </div>
      </div>
      @endforeach
   </div>
 </div>

</div> 
@endsection