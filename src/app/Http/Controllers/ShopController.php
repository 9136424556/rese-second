<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Mark;
use App\Models\Time;
use App\Models\Number;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::getShop(); 
        session()->flash('fs_msg', null);
        
        $areas = Area::all(); 
        $genres = Genre::all();

        return view('index', compact('shops','areas','genres'));
    }
    public function show($shop_id, Request $request)
    {
       $shops = Shop::find($shop_id);
       $users = Carbon::tomorrow()->format('Y-m-d');
       $marks = Mark::orderBy('posted_on','desc')->where('shop_id', $shop_id)->get();

       $times = Time::all();
       $numbers = Number::all();

       // 現在のユーザーがこの店舗にレビューを書いているかチェック
         // ユーザーがログインしている場合のみ処理を続行
         $hasReviewed = null; // 初期値を設定
          if (Auth::check()) {
              $user = Auth::user(); // 現在のユーザーを取得
              $hasReviewed = Mark::where('user_id', $user->id)
                          ->where('shop_id', $shop_id)
                          ->first();
          }

        
       return view('detail', compact('shops','users','times','numbers','marks','hasReviewed'));
    }   

    //左上メニューアイコン//
     public function menu()
    {
        $user = Auth::user();
        return view('menu', compact('user'));
    }
//検索機能
    public function search(Request $request)
    {
        if($request->has('reset')) {
            return redirect('/')->withInput();
        }

        $area_name = $request->input('area_id');
        $genre_name = $request->input('genre_id');
        $keyword = $request->input('keyword');

        $searchResult = Shop::searchShops($area_name, $genre_name, $keyword);
       
        $shops = $searchResult['shops'];
       
        $areas = Area::all();
        $genres = Genre::all();
        
       
        return view('index', compact('shops','areas','genres'));
    }

    public function sort(Request $request)
    {
        $sort = $request->query('sort', 'random');  // ソート条件 ('high', 'low', 'random')

        
        // ショップ一覧データを取得
        $query = DB::table('shops')
           ->leftJoin('marks', 'shops.id', '=', 'marks.shop_id')
           ->leftJoin('areas', 'shops.area_id', '=', 'areas.id') // エリア情報を左結合
           ->leftJoin('genres', 'shops.genre_id', '=', 'genres.id') // ジャンル情報を左結合
           ->select(
    'shops.id',
             'shops.shop_name', 
             'shops.image',
             'areas.name as area_name', 
             'genres.name as genre_name',
           DB::raw('COALESCE(AVG(marks.evaluate), 0) as average_rating'), // 評価の平均値
           DB::raw('COUNT(marks.id) as rating_count')  // 評価数
       )
       ->groupBy('shops.id', 'shops.shop_name');

       // ソート条件に応じて並び替え
       if ($sort === 'high') {
          $query->orderByDesc('average_rating');
       } elseif ($sort === 'low') {
          $query->orderBy('average_rating');
       } elseif ($sort === 'random') {
          $query->inRandomOrder();
       }

        // データ取得
        $shops = $query->get();

        return response()->json($shops);
    }
}
