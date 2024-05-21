@extends('layouts.app')

@section('main')

        

       

        <form method="POST"class="login-form" action="/login">
            @csrf
         <div class="login">
            <div class="register-head">
                Login
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
                 <input class="input-button" type="submit" value="ログイン">
              </div>
           </div>
          
             <a href="/register"><p>ユーザー登録はこちらから</p></a>  
        </form>
  @endsection
