@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin-shoplist.css')}}">
@endsection

@section('main')
<div class="main">
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
            <h2 class="header-logo">店舗一覧</h2>
        </div>
    </div>
    <div class="home">
        @foreach($shops as $shop)
        <div class="shop">
          <div class="shop-photo">
          @if (Str::startsWith($shop->image, 'https://'))
           <img src="{{ $shop->image }}" alt="店舗写真" width="35%" height="400px">
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
          </div>
          <div class="detail-and-like">
             <div class="detail-side">
                 <a href="{{ route('admin.detail', ['id' => $shop->id]) }}">
                 <button class="in-detail"  type="button">詳しく見る</button>
                 </a>
             </div> 
          </div>
        @endforeach
    </div>
</div>

@endsection