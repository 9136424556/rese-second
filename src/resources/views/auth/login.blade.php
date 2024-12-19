@extends('layouts.app')

@section('main')

        

       

       
    <div class="login-form">
            <div class="register-head">
                Login
            </div>
             <form method="POST"class="form" action="/login">
             @csrf
            <div class="input-form">
                <div class="mail-icon">
                   <input class="input-form-item" type="email" name="email" :value="old('email')" required placeholder="Email"/>
                </div>
              
                <div class="form-error">
                  @error('email')
                  {{ $message }}
                  @enderror
                  &emsp; <!--広めの空白-->
                </div>
            </div>

            <div class="input-form">
               <div class="password-icon">
                   <input class="input-form-item" type="password" name="password" required autocomplete="new-password" placeholder="Password"/>
               </div>
                 
               <div class="form-error">
                  @error('password')
                  {{ $message }}
                  @enderror
                 &emsp; <!--広めの空白-->
               </div>
            </div>
           
              <div class="button-auth">
                 <input class="input-button" type="submit" value="ログイン">
              </div>
          </form>
   </div>
          
            
       
  @endsection
