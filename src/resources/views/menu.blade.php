@extends('layouts.menu-app')

@section('main')
<div class="menu">
    
    <a href="/"><span class="square_btn"></span></a>
    
    <div class="menu-display">
                  <ul class="three-menu" style="display:block;">
                      <a href="/"><li class="menu-content"> Home</li></a>
                      <a href="/login"><li class="menu-content"> Logout</li></a>
                      <a href="/mypage/{user_id},['user_id' => $users->id ]"><li class="menu-content"> Mypage</li></a>
                </ul>
     </div>
</div>
@endsection