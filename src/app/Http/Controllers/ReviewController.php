<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Mark;
use App\Models\star;
use App\Http\Requests\ReviewRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    //レビュー投稿ページ
    public function review($shop_id)
    {
       $shops = Shop::find($shop_id);
       $stars = Star::all();

       return view('review', compact('shops', 'stars'));
    }
    
     //レビュー投稿処理
    public function reviewcreate(ReviewRequest $request)
    {
        $review = $request->only('shop_id', 'evaluate','review_comment');
        $user = Auth::user();

        $review['user_id'] = $user['id'];
        $review['posted_on'] = Carbon::today()->format('Y-m-d');

        // 画像がアップロードされた場合の処理
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');// storage/app/public/reviews に保存
            $review['image'] = $imagePath;
        }
        
        $shop_id = $request->only('shop_id');

        Mark::create($review);

        return view('review-done',compact('shop_id'));
    }

    public function edit($id)
    {
       $stars = Star::all();
       $review = Mark::findOrFail($id);// 指定IDの口コミを取得

       return view('review-edit', compact('review','stars'));
    }

    public function update(ReviewRequest $request, $id)
    {
       $review = Mark::findOrFail($id);

       // 更新データを準備
       $reviewData = $request->only('evaluate', 'review_comment');

       // 画像がアップロードされた場合
       if ($request->hasFile('image')) {
           // 古い画像を削除
           if ($review->image) {
              Storage::disk('public')->delete($review->image);
           }

           // 新しい画像を保存
           $imagePath = $request->file('image')->store('reviews', 'public');
           $reviewData['image'] = $imagePath;
       }

    // データを更新
    $review->update($reviewData); // データを更新

    return redirect()->route('review.edit', $id)->with('success', '口コミを更新しました！');
}
    public function markDelete($id)
    {
        $review = Mark::findOrFail($id);
        // 画像があれば削除
        if ($review->image) {
          Storage::disk('public')->delete($review->image);
        }
        $review->delete(); // 口コミを削除

        return back();
    }

    
}
