@extends('layouts.app')

@section('main')


        

        <form method="POST" class="register-form" action="{{ route('register') }}">
            @csrf
    <div class="register">
            <div class="register-head">
                Registration
            </div>
             
            <div class="input-form">
                <div class="user-icon"></div>
                <input id="name" class="name" type="text" name="name" :value="old('name')" placeholder="Username" required autofocus autocomplete="name" />
            </div>

            <div class="input-form">
                <div class="mail-icon"></div>
                <input id="email" class="email" type="email" name="email" :value="old('email')" required placeholder="Email"/>
            </div>

            <div class="input-form">
               <div class="password-icon"></div>
                <input id="password" class="password" type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
            </div>

        <div class="button">
            <input class="input-button" type="submit" value="登録">
        </div>
            
    </div>

    <a href="/login"><p>ログインはこちらから</p></a>
 </form>
   @endsection
    
