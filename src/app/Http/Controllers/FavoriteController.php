<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function create($shop_id)
    {
        $user = Auth::user();
        // すでにいいねしていない場合のみ追加
        if (!$user->likes()->where('shop_id', $shop_id)->exists()) {
          $user->likes()->attach($shop_id); // いいねを追加
        }
        return back();
    }
    public function delete($shop_id)
    {
        $user = Auth::user();
        $user->likes()->detach($shop_id);
        return back();
    }
}
