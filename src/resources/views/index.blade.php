@extends('header.list')

@section('main')

    <form class="form" action="/detail/{shop_id}" method="get">
 @csrf
  <div class="home">
    @foreach($shops as $shop)
    <div class="shop-form">
      <div class="shop-read">
        <img  src= "{{ $shop->image }}" alt="" width="100%">
     <h1 class="shop-title">{{ $shop->shop_name }}</h1>
        <div class="place-category">
           <p class="shop-tag">#{{ $shop->place }}</p>
            <p class="shop-tag">#{{ $shop->category }}</p>
       </div>

     <a href="{{ route('detail.get', ['shop_id' => $shop->id]) }}"><button class="in-detail"  type="button">詳しく見る</button></a>
     </div>
     </div>
    @endforeach
  </div>
  
 </form>

@endsection