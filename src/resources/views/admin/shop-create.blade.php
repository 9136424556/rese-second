@extends('layouts.admin-app')

@section('main')
<div class="shop-header">
    <div class="shop-header__title">
        <h2 class="shop-header__logo">新規作成</h2>
    </div>
    <div class="shop-header__back">
        <a class="shop-header__back-link" href="{{ route('managerIndex') }}">管理画面に戻る</a>
    </div>
</div>
<div class="shop-message">
    {{ session('message') ?? '' }}&emsp;
</div>
<div class="shop-main">
    <div class="show">
        <form class="show-form" action="/manager/show" method="get">
            <div class="show-item">
                <label class="show-title">店名</label>
                <input class="show-name__input" type="text" name="shopName" value="{{ old('shopName') }}" onchange="submit()"/>
            </div>
            <div class="show-error">
                @error('name')
                    {{ $message }}
                @enderror
                &emsp;
            </div>
            <div class="show-item">
                <label class="show-title">店舗写真</label>
                <select class="show-image__select" name="shopImage" onchange="submit()">
                    <option value="" hidden>選択してください</option>
                    @foreach($images as $image)
                    <option value="{{ $image['image_url'] }}"
                    {{ old('shopImage') == $image['image_url'] ? 'selected' : '' }}>
                        {{ $image['image_name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="show-error">
                @error('img_url')
                    {{ $message }}
                @enderror
                &emsp;
            </div>
            <div class="show-item">
                <label class="show-title">地域</label>
                <select class="show-area__select" name="shopArea" onchange="submit()">
                    <option value="" hidden>選択してください</option>
                    @foreach($areas as $area)
                    <option value="{{ $area['name'] }}"
                    {{ old('shopArea') == $area['name'] ? 'selected' : '' }}>
                        {{ $area['name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="show-error">
                @error('area')
                    {{ $message }}
                @enderror
                &emsp;
            </div>
            <div class="show-item">
                <label class="show-title">ジャンル</label>
                <select class="show-genre__select" name="shopGenre" onchange="submit()">
                    <option value="" hidden>選択してください</option>
                    @foreach($genres as $genre)
                    <option value="{{ $genre['name'] }}"
                    {{ old('shopGenre') == $genre['name'] ? 'selected' : '' }}>
                        {{ $genre['name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="show-error">
                @error('genre')
                    {{ $message }}
                @enderror
                &emsp;
            </div>
            <div class="show-item">
                <label class="show-title">店舗概要</label>
                <textarea class="show-comment__text" name="shopComment" cols="50" rows="5">{{ old('shopComment') }}</textarea>
            </div>
            <div class="show-comment__button">
                <button class="show-comment__button-submit" type="submit">店舗概要決定</button>
            </div>
            <div class="show-error">
                @error('comment')
                    {{ $message }}
                @enderror
                &emsp;
            </div>
            <div class="show-item">
                <label class="show-title">店舗代表者名</label>
                <select class="show-manager__select" name="shopManager" onchange="submit()">
                    <option value="">未定</option>
                    @foreach($managers as $manager)
                    <option value="{{ $manager['id'] }}"
                    {{ old('shopManager') == $manager['id'] ? 'selected' : '' }}>
                        {{ $manager['name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="create">
        <form class="create-form" action="/manager/create" method="post">
            @csrf
            <div class="create-shop">
                <div class="create-shop__name">
                    <input class="create-shop__name-input" type="text" name="name" value="{{ old('shopName') ?? '' }}" readonly>
                </div>
                <div class="create-shop__image">
                    @if(!empty(old('shopImage')))
                    <img class="create-shop__image-img" src="{{ asset(old('shopImage')) }}" alt="店舗写真">
                    @else
                    <div class="create-shop__image-none">
                        No&emsp;Image
                    </div>
                    @endif
                    <input type="hidden" name="img_url" value="{{ old('shopImage') ?? '' }}">
                </div>
                <div class="create-shop__data">
                    <div class="create-shop__area">
                        <span class="data-parts">#</span>
                        <input class="data-input" type="text" name="area" value="{{ old('shopArea') ?? '' }}" readonly>
                    </div>
                    <div class="create-shop__genre">
                        <span class="data-parts">#</span>
                        <input class="data-input" type="text" name="genre" value="{{ old('shopGenre') ?? '' }}" readonly>
                    </div>
                </div>
                <div class="create-shop__comment">
                    <textarea class="create-shop__comment" name="comment" cols="33" rows="8" readonly>{{ old('shopComment') ?? '' }}</textarea>
                </div>
            </div>
            <div class="create-manager">
                <table class="create-table">
                    <tr class="create-tr">
                        <th class="create-th">店舗代表者</th>
                        <td class="create-td">
                            {{ session('managerName')  ?? '' }}
                            <input type="hidden" name="managerId" value="{{ old('shopManager') ?? '' }}">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="create-button">
                <button class="create-button__submit" type="submit">作成</button>
            </div>
        </form>
    </div>
</div>
@endsection