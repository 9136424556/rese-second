@extends('layouts.admin-app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/addShop.css')}}">
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
            <h2 class="header-logo">店舗を追加</h2>
        </div>
    </div>
    <div class="admin-content">
        <form action="/admin/create/shop" method="post" enctype="multipart/form-data">
            @csrf
            <table class="admin-table">

                <tr class="admin-tr">
                    <th class="admin-th">CSVファイル</th>
                    <td class="admin-td">
                        <input type="file" name="csv_file" id="csv_file" accept=".csv">
                    </td>
                </tr>
                <tr class="admin-tr">
                    <th>&emsp;</th>
                    <td>
                      @error('csv_file')
                        {{ $message }}
                      @enderror
                    </td>
                </tr>
                
            </table>
            <div class="admin-submit-button">
                <button class="submit">登録</button>
            </div>
        </form>
    </div>
</div>

@endsection