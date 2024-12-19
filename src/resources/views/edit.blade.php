@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('main')
<div class="edit">
    <div class="edit-title">
        <h2 class="edit-title-head">予約内容</h2>
    </div>
  <div class="create-reserv">
                                            <!--↓Route::get('/edit/confirm'~へ値を送る-->
    <form class="reserv-input-form" action="/edit/confirm"  method="get">
      @csrf
         <!--予約日入力-->
          <div class="reservation-input-list">
             <input  class="date" type="date" name="sendDate" list="daylist" min="{{ $tomorrow }}" value="{{ old('sendDate') }}"  onchange="submit()">
             <div class="form-error">
                            @error('date')
                            {{ $message }}
                            @enderror
                            &emsp;
                        </div>
          </div>
         <!--予約時間選択-->
          <div class="reservation-input-list">
             <select class="select_items" name="sendTime" onchange="submit()">
                <option value="" hidden>時間を選択してください</option>
                @foreach($times as $time)
                <option value="{{ $time['reserved_time'] }}" {{ old('sendTime') == $time['reserved_time'] ? 'selected' : ''}}>
                    {{$time['reserved_time'] }}
                </option>
                @endforeach
             </select>
             <div class="form-error">
                  @error('time')
                  {{ $message }}
                  @enderror
                 &emsp; <!--広めの空白-->
             </div>
          </div>
         <!--予約人数選択-->
          <div class="reservation-input-list">         <!--↓選択後にボタンを押さずにsubmitして、確認フォームに遷移-->
           <select class="select_items" name="sendNumber" onchange="submit()">
             <option value="" hidden>人数を選択してください</option>
             @foreach($numbers as $number)
             <option value="{{ $number['reserved_number']}}" {{ old('sendNumber') == $number['reserved_number'] ? 'selected' : '' }}>
                {{ $number['reserved_number'] }}
             </option>
             @endforeach
          </select>
          <div class="form-error">
                  @error('number')
                  {{ $message }}
                  @enderror
                 &emsp; <!--広めの空白-->
             </div>
         </div>

      <!--選択した店舗情報-->
        <input type="hidden" name="sendId" value="{{ $reservation['id'] }}">
     </form>
    </div>

       <div class="confirm-form">
           <form action="/edit/complete" method="POST">
            @csrf
            <table class="detail-confirm">
                <tr>
                    <th class="reserv-th">Shop</th>
                    <td class="reserv-td">
                        {{ $reservation->shop->shop_name }}
                        <input type="hidden" name="id" value="{{ $reservation['id'] }}">
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Date</th>
                    <td class="reserv-td">
                        <input type="text" name="date" value="{{ old('sendDate') ?? $reservation['reservation_date'] }}" readonly/>
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Time</th>
                    <td class="reserv-td">
                        <input type="text" name="time" value="{{ old('sendTime') ?? $reservation['reservation_time']}}" readonly/>
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Number</th>
                    <td class="reserv-td">
                        <input type="text" name="number" value="{{ old('sendNumber') ?? $reservation['number']}}" readonly/>
                    </td>
                </tr>
            </table>
            <div class="submit-button">
                 <button class="submit" type="submit">変更する</button>
            </div>    
          </form>
          
       </div>
</div>
@endsection