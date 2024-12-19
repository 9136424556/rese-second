@extends('layouts.admin-app')

@section('main')
<div class="main">
    <div class="admin-header">
        <div class="header-message">

        </div>
        <div class="admin-header-title">
            <h2 class="header-logo">店舗代表者登録</h2>
        </div>
    </div>
    <div class="admin-content">
        <form action="/admin/create" method="post">
            @csrf
            <table class="admin-table">
                <tr class="admin-tr">
                    <th class="admin-th">店舗代表者氏名</th>
                    <td class="admin-td">
                        <input type="text" name="name" value="{{ old('name') }}" >
                    </td>
                </tr>
                <!--エラー文-->
                <tr class="admin-tr">
                    <th>&emsp;</th>
                    <td>
                      @error('name')
                      {{ $message }}
                      @enderror
                    </td>
                  
                </tr>

                <tr class="admin-tr">
                    <th class="admin-th">メールアドレス</th>
                    <td class="admin-td">
                        <input type="email" name="email" value="{{ old('email') }}" >
                    </td>
                </tr>
                 <tr class="admin-tr">
                    <th>&emsp;</th>
                    <td>
                      @error('email')
                      {{ $message }}
                      @enderror
                    </td>
                 </tr>

                <tr class="admin-tr">
                    <th class="admin-th">パスワード</th>
                    <td class="admin-td">
                        <input type="text" name="password" >
                    </td>
                </tr>
                <tr class="admin-tr">
                <th>&emsp;</th>
                    <td>
                      @error('password')
                      {{ $message }}
                      @enderror
                    </td>
                </tr>

                <tr class="admin-tr">
                    <th class="admin-th">担当店舗</th>
                    <td class="admin-td">
                        <select class="admin-select-item" name="shop_id">
                            <option value="">未定</option>
                            @foreach($shops as $shop)
                            <option value="{{ $shop['id'] }}">{{ $shop['shop_name'] }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr class="admin-tr">
                    <th class="admin-th">&emsp;</th>
                    <td class="admin-td">
                        <div class="admin-content__error">
                            @error('shop_id')
                                {{ $message }}
                            @enderror
                            &emsp;
                        </div>
                    </td>
                </tr>
            </table>
            <div class="admin-submit-button">
                <button class="submit">登録</button>
            </div>

            <div>
                <p><a href="/admin/shop">店舗を追加</a></p>
                <p><a href="/admin/list">口コミ一覧</a></p> 
            </div>
        </form>
    </div>
</div>
@endsection