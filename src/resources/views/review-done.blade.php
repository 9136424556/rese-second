@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review-done.css')}}">
@endsection

@section('main')
<div class="complete">
    <h2 class="complete-message">レビューを投稿しました</h2>
    <div class="button-login">
       <a href="{{ route('detail', ['shop_id' => $shop_id['shop_id']])}}"><button class="input-button-login" type="button">戻る</button></a>
   </div>
</div>
@endsection