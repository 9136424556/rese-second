@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('main')
<div class="detail-shop-class">
    <button class="rebirth-button"><a href="/">＜</a></button>
   <div class="detail-shop-introduction">
      <h1>{{  $shops->shop_name }}</h1>
      @if (Str::startsWith($shops->image, 'https://'))
        <img src="{{ $shops->image }}" alt="店舗写真" width="100%" height="400px">
      @else
        <img  src= "{{ Storage::url($shops->image) }}" alt="店舗写真" width="100%" height="400px">
      @endif
        <div class="detail-place-category">
            <p class="shop-tag-detail">{{ $shops->area->name }}</p>
            <p class="shop-tag-detail">{{ $shops->genre->name }}</p>
        </div>
        <div class="like-push">
            <p class="shop-introduction">{{ $shops->introduction}}</p>
        </div>
        <div class="review-see">
            <a href="#review" type="button" v-if="!hasMyReview(p.reviews)">
               <button class="all-reviews">全ての口コミ情報</button>
            </a>
        </div>
        <!--レビューのモーダルウィンドウ表示ボタン-->
         <!--ログイン済みで口コミを投稿していない場合に表示-->
        @if(Auth::check() && !$hasReviewed)
          <div class="review-create">
               <a class="link-review" href="{{ route('review', ['shop_id' => $shops['id']] )}}">
                  口コミを投稿する
               </a>
          </div>
          <!--口コミ投稿済みの場合-->
        @elseif (Auth::check() && $hasReviewed)
        <div class="myreview">
          <!--自分の書いた口コミがあれば編集ボタンを表示する-->
           @if($hasReviewed)
           <div class="edit-w-button">
             <a class="link-review" href="{{route('review.edit', $hasReviewed->id) }}">口コミを編集する</a>
             <form action="{{ route('review.destroy', $hasReviewed->id) }}" method="POST" style="display: inline;">
             @csrf
                  <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？')">削除</button>
             </form>
           </div>
           @endif
          <div class="review-star">
              {{ $hasReviewed['evaluate'] }}
          </div>
          <div class="review-comment">
             <p>{{ $hasReviewed['review_comment']}}</p>
          </div>
          <div class="review-date">
              {{ $hasReviewed['posted_on']}}
          </div>
           @if($hasReviewed->image)
              <div class="review-image">
                 <img src="{{ asset('storage/' . $hasReviewed->image) }}" alt="口コミ画像" width="200px">
              </div>
           @endif
           
        </div>
        @endif
   </div>
  
   
  
  <div class="detail-form">
    <div class="reserv-title">
        <h2 class="detail-header">予約</h2>
    </div>
    <div class="create-reserv">
    <form class="reserv-input-form" action="/confirm"  method="get">
      @csrf
         <!--予約日入力-->
          <div class="reservation-input-list">
             <input  class="date" type="date" name="sendDate" list="daylist" min="{{$users}}" value="{{ old('sendDate') }}"  onchange="submit()">
             <div class="form-error">
                  @error('date')
                  {{ $message }}
                  @enderror
                 &emsp; <!--広めの空白-->
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
        <input type="hidden" name="sendId" value="{{ $shops['id'] }}">
     </form>
    </div>

       <div class="confirm-form">
           <form action="/detail" method="POST">
            @csrf
            <table class="detail-confirm">
                <tr>
                    <th class="reserv-th">Shop</th>
                    <td class="reserv-td">
                        {{ $shops['shop_name'] }}
                        <input type="hidden" name="shop_id" value="{{ $shops['id'] }}">
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Date</th>
                    <td class="reserv-td">
                        <input type="text" name="date" value="{{ old('sendDate') ?? ''}}" readonly/>
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Time</th>
                    <td class="reserv-td">
                        <input type="text" name="time" value="{{ old('sendTime') ?? ''}}" readonly/>
                    </td>
                </tr>
                <tr>
                    <th class="reserv-th">Number</th>
                    <td class="reserv-td">
                        <input type="text" name="number" value="{{ old('sendNumber') ?? ''}}" readonly/>
                    </td>
                </tr>
            </table>
            <div class="submit-button">
                 <input type="hidden" id="user_id" name="user_id" value="{{ $users }}">
                 <input class="submit" type="submit" value="予約する">
            </div>    
          </form>
          
       </div>
                            
                    
       
    
    
    </div>
      <!-- レビュー投稿のモーダル ・・・ ③ -->
    <div class="modal-fade" id="review">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                   <button class="rebirth-button2"><a href="#" >×</a></button>
                </div>
               
               
                <div class="modal-body">
                    @if($marks->isEmpty())
                        <p class="review-none">このお店のレビューはまだありません</p>
                    @else
                        @foreach($marks as $mark)
                        <div class="one-review">
                          <div class="review-star">
                              {{ $mark['evaluate'] }}
                          </div>
                          <div class="review-comment">
                            <p>{{ $mark['review_comment']}}</p>
                          </div>
                          <div class="review-date">
                            {{ $mark['posted_on']}}
                          </div>
                          <div class="review-date">
                            {{ $mark->users->name }}
                          </div>
                          @if($mark->image)
                          <div class="review-image">
                            <img src="{{ asset('storage/' . $mark->image) }}" alt="口コミ画像" width="200px">
                          </div>
                          @endif
                        </div>
                        @endforeach
                    @endif
              </div> 
              
           </div>
        </div>
    </div>
 
</div>
@endsection