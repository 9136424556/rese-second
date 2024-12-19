<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [
     'id'
    ];
    protected $fillable = [
        'shop_name',
        'area_id',
        'genre_id',
        'image',
        'introduction',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function likes()
    {
        return $this->belongsToMany(
           User::class,    // 関連付けるモデル
             'likes',        // 中間テーブル名
   'shop_id',      // 中間テーブルの店舗外部キー
   'user_id'       // 中間テーブルのユーザー外部キー
        )->withTimestamps();
    }
    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->marks()->avg('evaluate') ?? 0;  // 評価の平均
    }

    public function getRatingCountAttribute()
    {
        return $this->marks()->count(); // 評価数
    }

    
    //店舗一覧ページ　表示設定（ログインしたユーザーごとにお気に入りの表示内容が変わる）//
    public static function getshop()
    {
        // `likes`リレーションにログインユーザー条件を付与し、関連データを取得
        $shops = Shop::with('area','genre')->with([
            'likes' => function ($query) {
                $query->where('user_id',Auth::id());
            },
        ])->get();
        // 画像パスの処理
        foreach ($shops as $shop) {
           
        $shop->image =  $shop->image &&  Str::startsWith($shop->image, 'http')
            ? $shop->image
            : asset('storage/' . $shop->image);
        }
        return $shops;
    }

  
//店舗検索//
    public static function searchShops($area_name, $genre_name, $keyword)
    {
        $query = Shop::query();
        $conditions = array();

        if(!empty($area_name)) {
            $query->where('area_id', 'LIKE', $area_name);
        }

        if(!empty($genre_name)) {
            $query->where('genre_id', 'LIKE', $genre_name); 
        } 

        if(!empty($keyword)) {
            array_push($conditions, $keyword);
            $query->where('Shop_name', 'like', "%$keyword%");
        }
        
        $shops = $query->get();
       

        return compact('shops');
    }
    
    //並び替え機能の実装
    public function scopeOrderByRating($query, $order = 'desc')
    {
        return $query->withCount(['marks as rating_count' => function ($query) {
                $query->select(DB::raw('AVG(evaluate)'));
            }])
            ->orderBy('rating_count', $order);
    }


}
