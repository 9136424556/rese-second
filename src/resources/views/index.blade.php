@extends('layouts.list')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
  <div class="home" id="shop-list">
    
    @foreach($shops as $shop)
    <div class="shop">
        <div class="shop-photo">
         @if (Str::startsWith($shop->image, 'https://'))
           <img src="{{ $shop->image }}" alt="店舗写真" width="100%" height="400px">
         @else
           <img class="shop-img" src="{{ Storage::url($shop->image) }}" alt="店舗写真">
         @endif
        </div>
        <div class="shop-content">
          <div>
            <h1 class="shop-title">{{ $shop->shop_name }}</h1>
          </div>
        
          <div class="place-category">
           <p class="shop-tag">#{{ $shop->area->name }}</p>
           <p class="shop-tag">#{{ $shop->genre->name }}</p>
          </div>

      <div class="detail-and-like">
          <div class="detail-side">
            <a href="{!! '/detail/' . $shop->id !!}">
              <button class="in-detail"  type="button">詳しく見る</button>
            </a>
          </div>  
          <div class="like-side" >
             @if(Auth::check() )
               @if(count($shop->likes) == 0)
               <form class="like-or-unlike" action="{{ route('like', ['shop_id' => $shop->id]) }}" method="POST">
               @csrf
                <input  class="like-icon" type="image" src="/img/unlike.png"  width="32px" height="32px" alt="いいね">
               </form>

               @else
               <form class="like-or-unlike" action="{{ route('unlike', ['shop_id' => $shop->id]) }}" method="POST">
               @csrf
                 <input class="like-icon" type="image" src="/img/like.png"  width="32px" height="32px">
               </form>
               @endif
            @endif
           </div>
       </div>

        </div>
     </div>
    @endforeach
    
  </div>


@endsection