@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/multi-login.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="main-content">
        <div class="main-title">
            <h2 class="header-logo">ManagementLogin</h2>
        </div>
        <div class="main-item">
            <form action="/multi/login" class="form" method="POST">
                @csrf
                <div class="form-item">
                    <div class="form-item-input">
                         <input class="item-input" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                   <div class="form-error">
                        @error('email')
                         {{ $message }}
                        @enderror
                   </div>
                </div>

                <div class="form-item">
                    <div class="form-item-input">
                        <input class="item-input" type="password" name="password" value="{{ old('password') }}" placeholder="Password">
                    </div>
                    <div class="form-error">
                        @error('password')
                         {{ $message }}
                        @enderror
                    </div>
                </div>
                <!--役職を選択-->
                <div class="form-item">
                    <select class="item-select" name="guard">
                        <option value="" hidden>役職を選択してください</option>
                        <option value="admin">管理者</option>
                        <option value="manager">店舗代表者</option>
                    </select>
                    <div class="form-error">
                        @error('guard')
                         {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-button">
                    <button type="submit" class="submit-button">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection