@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-detail.css')}}">
@endsection

@section('main')
<div class="main">
    <div class="rebirth">
        <button class="rebirth-button"><a href="/admin/list">＜</a></button>
    </div>

    <div class="admin-header">
        <div class="header-message">
        @if (session('error'))
         <div class="alert alert-danger">
            {{ session('error') }}
         </div>
        @endif
        @if(session('success'))
         <div class="alert alert-danger">
            {{ session('success') }}
         </div>
        @endif
        </div>
        <div class="admin-header-title">
            <h2 class="header-logo">店舗情報</h2>
        </div>
    </div>

    <div class="home">
      <h1>{{  $shop->shop_name }}</h1>
      <div class="shop-photo">
          @if (Str::startsWith($shop->image, 'https://'))
             <img src="{{ $shop->image }}" alt="店舗写真" width="100%" height="400px">
          @else
             <img  src= "{{ Storage::url($shop->image) }}" alt="店舗写真" width="100%" height="400px">
          @endif
      </div>
       
      <div class="detail-place-category">
           <p class="shop-tag-detail">{{ $shop->area->name }}</p>
           <p class="shop-tag-detail">{{ $shop->genre->name }}</p>
      </div>
        
      <div class="like-push">
           <p class="shop-introduction">{{ $shop->introduction}}</p>
      </div>
      <div class="review-all">
        <h2>口コミ一覧</h2>
        @if($marks->isEmpty())
            <p class="review-none">このお店のレビューはまだありません</p>
        @else
          @foreach($marks as $mark)
            <div class="review-star">
                {{ $mark['evaluate'] }}
            </div>
            <div class="review-comment">
                <p>{{ $mark['review_comment']}}</p>
            </div>
            <div class="review-date">
                {{ $mark['posted_on']}}
            </div>
            @if($mark->image)
              <div class="review-image">
                 <img src="{{ asset('storage/' . $mark->image) }}" alt="口コミ画像" width="200px">
              </div>
            @endif
            <div class="delete-button">
              <form action="{{ route('review.destroy', $mark->id) }}" method="POST" style="display: inline;">
              @csrf
                <button type="submit" class="submit" onclick="return confirm('この口コミを削除しますか？')">削除</button>
              </form>
            </div>
          @endforeach
        @endif
       </div>
        
   </div>
</div>

@endsection