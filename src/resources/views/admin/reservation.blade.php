@extends('layouts.admin-app')

@section('main')
@section('content')
<div class="reservation-header">
    <div class="reservation-header__title">
        <h2 class="reservation-header__logo">予約一覧</h2>
    </div>
    <div class="reservation-header__link">
        <a class="reservation-header__back" href="{{ route('managerIndex') }}">管理画面に戻る</a>
    </div>
</div>
<div class="reservation-error">
    @error('reservationId')
    {{ $message }}
    @enderror
    &emsp;
</div>
<div class="reservation-notice">
    <div class="reservation-notice__title">
        <h3 class="reservation-notice__logo">お客様にお知らせメールを送信</h3>
    </div>
    <form class="reservation-notice__form" action="/mail" method="post">
        @csrf
        <div class="reservation-notice__form-item">
            <select class="reservation-notice__select" name="reservationId">
                <option value="" hidden>お客様氏名</option>
                @foreach($reservations as $reservation)
                <option value="{{ $reservation['id'] }}">{{ $reservation['user']['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="reservation-notice__button">
            <button class="reservation-notice__button-submit" type="submit">送信</button>
        </div>
    </form>
</div>
<div class="reservation-notice__message">
    {{ session('message') ?? '' }}&emsp;
</div>
<div class="reservation-main">
    @foreach($reservations as $key => $reservation)
    <div class="reservation-main__content">
        <table class="reservation-main__table">
            <tr class="reservation-main__tr">
                <th class="reservation-main__th">予約番号</th>
                <td class="reservation-main__td">{{ $key + 1 }}</td>
            </tr>
            <tr class="reservation-main__tr">
                <th class="reservation-main__th">お客様氏名</th>
                <td class="reservation-main__td">{{ $reservation['user']['name'] }}</td>
            </tr>
            <tr class="reservation-main__tr">
                <th class="reservation-main__th">予約日付</th>
                <td class="reservation-main__td">{{ $reservation['date'] }}</td>
            </tr>
            <tr class="reservation-main__tr">
                <th class="reservation-main__th">予約時間</th>
                <td class="reservation-main__td">{{ $reservation['time'] }}</td>
            </tr>
            <tr class="reservation-main__tr">
                <th class="reservation-main__th">予約人数</th>
                <td class="reservation-main__td">{{ $reservation['number'] }}</td>
            </tr>
        </table>
    </div>
    @endforeach
</div>
@endsection