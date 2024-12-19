@extends('layouts.menu-app')

@section('main')
<div class="menu">
    
    <a href="javascript:history.back();"><span class="square_btn"></span></a>
    
    <div class="menu-display">
      
        <p class="menu-content"><a href="/" class=""> Home</a></p>
       <!-- ログインしている場合 -->
        @if(Auth::check() )
        <form class="menu-content" name="logout" action="{{ route('logout') }}" method="POST">
          @csrf
         <p class="menu-content"><a  onclick="document.logout.submit();">Logout</a></p>
        </form>
                     
         <p class="menu-content"><a href="/mypage" >Mypage</a></p>
         <!--管理者ログインの場合に表示-->
         @if(isset($user) && $user['role'] == 'company')
         <div class="menu-item">
            <a class="menu-content" href="{{ route('multiindex') }}">ManagementLogin</a>
         </div>
        @endif
         <!--　ログイン前、していない場合-->
        @else
         <p class="menu-content"><a href="/register" >Registration</a></p>
         <p class="menu-content"><a href="/login" >Login</a></p>
        @endif
       
    </div>
</div>
@endsection