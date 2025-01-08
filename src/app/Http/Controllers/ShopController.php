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
use Illuminate\Support\Facades\Log;

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
       $marks = Mark::orderBy('posted_on','desc')->where('shop_id', $shop_id)->with('users')->get();

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
             //色付きの星の数だけ数値に変換
             DB::raw("
               COALESCE(AVG(
                  CASE 
                     WHEN marks.evaluate = '★★★★★' THEN 5
                     WHEN marks.evaluate = '★★★★☆' THEN 4
                     WHEN marks.evaluate = '★★★☆☆' THEN 3
                     WHEN marks.evaluate = '★★☆☆☆' THEN 2
                     WHEN marks.evaluate = '★☆☆☆☆' THEN 1
                     ELSE 0
                 END
              ), 0) as average_rating
           "),// 評価の平均値
           DB::raw('COUNT(marks.id) as rating_count')  // 評価数
       )
       ->groupBy(
        'shops.id',
                'shops.shop_name',
                'shops.image', 
                'areas.name', 
                'genres.name'
       );

       // ソート条件に応じて並び替え
       if ($sort === 'high') {
         $query->reorder(); // デフォルトの並び順をリセット
         $query->orderByRaw("
          CASE 
             WHEN rating_count = 0 THEN 1
             ELSE 0
           END ASC
          ")->orderBy('average_rating', 'DESC')
            ->orderBy('shops.id', 'ASC');
       } elseif ($sort === 'low') {
          $query->reorder(); // デフォルトの並び順をリセット
        // 評価がないショップを最後尾にする条件を追加
          $query->orderByRaw("
            CASE 
              WHEN COUNT(marks.id) = 0 THEN 1 
              ELSE 0 
            END ASC
          ")->orderBy('average_rating', 'ASC')->orderBy('shops.id', 'ASC'); // 通常の評価順 -> shopのid順
       } elseif ($sort === 'random') {
          $query->inRandomOrder();
       }

        // データ取得
        try {
            // クエリ実行部分
            Log::info('Query Debug:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
            $shops = $query->get();
        } catch (\Exception $e) {
            // エラーをログに記録
            Log::error('Error fetching shops: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        return response()->json($shops);
    }
}
