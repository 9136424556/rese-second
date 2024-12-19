@extends('layouts.admin-app')

@section('css')
@endsection

@section('main')
<div class="main">
    <div class="manager-nav">
        @if(!empty($user['shop_id']))
        <a class="manager-link" href="{{ route('managerReservation', ['store' => $user['shop_id']]) }}">担当店舗予約情報確認</a>
        @else
        <div class="manager-link__dummy">担当店舗予約情報確認</div>
        @endif
    </div>
    <div class="manager-nav">
        @if(!empty($user['shop_id']))
        <a class="manager-link" href="{{ route('managerEdit', ['store' => $user['shop_id']]) }}">担当店舗情報更新</a>
        @else
        <div class="manager-link__dummy">担当店舗情報更新</div>
        @endif
    </div>
    <div class="manager-nav">
        <a class="manager-link" href="{{ route('managerNew') }}">店舗情報新規作成</a>
    </div>
    <div class="manager-content">
        <div class="manager-content__title">
            <h2 class="manager-content__logo">画像アップロード</h2>
        </div>
        <div class="manager-content__main">
            <!--フォルダから画像をアップロード-->
            <form class="manager-content__form" action="/manager/upload" method="post" enctype="multipart/form-data">
                @csrf
                <div class="manager-content__item">
                    <input class="manager-content__input" type="file" name="image">
                </div>
                <div class="manager-content__button">
                    <button class="manager-content__submit" type="submit">アップロード</button>
                </div>
            </form>
        </div>
    </div>
    <div class="manager-content__message">
        {{ session('message') ?? '' }}&emsp;
    </div>
</div>
@endsection