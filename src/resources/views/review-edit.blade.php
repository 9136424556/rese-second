@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('main')
<div class="reviewUserForm">
    <div class="reviewed-shop">
     <h1 class="how-shop">今回のご利用はいかがでしたか?</h1>
     <div class="shop">
         <div class="shop-photo">
           @if (Str::startsWith($review->shop->image, 'https://'))
             <img class="shop-img" src="{{ $review->shop->image }}" alt="店舗写真"  >
           @else
             <img class="shop-img" src="{{ Storage::url($review->shop->image) }}" alt="店舗写真">
           @endif
         </div>
         <div class="shop-content">
            <div>
              <h1 class="shop-title">{{ $review->shop->shop_name }}</h1>
            </div>
        
            <div class="place-category">
               <p class="shop-tag">#{{ $review->shop->area->name }}</p>
               <p class="shop-tag">#{{ $review->shop->genre->name }}</p>
            </div>

            <div class="detail-side">
               <a href="{!! '/detail/' . $review->shop->id !!}">
                  <button class="in-detail"  type="button">詳しく見る</button>
               </a>
            </div>  
         </div>
     </div>
  </div>
<div class="main">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('review.update', $review->id) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="shop-name">
            <h1>{{ $review->shop->shop_name}}</h1>
            <input type="hidden" name="shop_id" value="{{ $review->shop_id }}">
        </div>

        <!-- 星の数セレクト -->
        <div class="review-star">
            <span class="star" data-value="★☆☆☆☆">★</span>
            <span class="star" data-value="★★☆☆☆">★</span>
            <span class="star" data-value="★★★☆☆">★</span>
            <span class="star" data-value="★★★★☆">★</span>
            <span class="star" data-value="★★★★★">★</span>
            <input type="hidden" name="evaluate" id="evaluate" value="{{ $review->evaluate }}">
            
            <div class="form-error">
                @error('evaluate')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-comment">
            <p><label for="text">口コミを投稿(400字まで入力可)</label></p>
            <textarea id="text" class="review-comment-field" name="review_comment" placeholder="コメントを記入してください">{{ old('review_comment', $review->review_comment) }}</textarea>
            <div class="form-error">
                @error('review_comment')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-image">
          <label for="image">画像をアップロード (JPEG, PNGのみ)</label>
            @error('image')
              {{ $message }}
            @enderror
            &emsp;
            <!-- 画像プレビュー用 -->
           
            <div class="image-preview" id="image-preview">
                <input class="input-image" type="file" name="image" id="image" accept="image/jpeg, image/png" hidden>
                <img id="preview" src="{{ asset('storage/' . $review->image) }}" alt="プレビュー画像" >
                <p class="placeholder-text">クリックして写真を追加</p>
            </div>
            
        </div>
        </div>
        <div class="review-create-button">
            <button class="submit"  type="submit">口コミを更新</button>
        </div>
    </form>
 
</div>
    
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];  // 選択したファイル
        const preview = document.getElementById('preview');   // プレビュー用imgタグ
        const placeholderText = document.querySelector('.placeholder-text'); // プレースホルダーテキスト要素

        // ファイルが存在し、画像ファイルである場合
        if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
            const reader = new FileReader(); // FileReaderを使って画像を読み込む
            reader.onload = function(e) {
                preview.src = e.target.result; // imgタグのsrcに画像データをセット
                preview.style.display = 'block'; // プレビュー画像を表示
                // プレースホルダーテキストを非表示
                if (placeholderText) {
                    placeholderText.style.display = 'none';
                }
            };
            reader.readAsDataURL(file); // ファイルをDataURLとして読み込む
        } else {
            // ファイルが指定フォーマット以外の場合、エラーメッセージを表示
            alert('JPEGまたはPNG形式の画像をアップロードしてください。');
            preview.src = ''; // プレビューをクリア
            preview.style.display = 'none';
            event.target.value = ''; // inputの選択をリセット
            // プレースホルダーテキストを再表示
            if (placeholderText) {
                placeholderText.style.display = 'block';
            }
        }
    });

    document.getElementById('image-preview').addEventListener('click', function () {
        // input要素をクリックしたことにする
        document.getElementById('image').click();
    });
    
     //星の数を選択して評価
     document.addEventListener("DOMContentLoaded", () => {
       const stars = document.querySelectorAll(".star");
       const evaluateInput = document.getElementById("evaluate");

       // 初期状態でevaluateの値を反映
       const currentEvaluate = evaluateInput.value; // ★★☆☆☆など
       if (currentEvaluate) {
        // 対応する星の数に基づいて選択状態を設定
        stars.forEach((star, index) => {
            if (star.getAttribute("data-value") === currentEvaluate) {
                // 対応する星を選択状態にする
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.add("selected");
                }
            }
        });
       }

        // 星をクリックしたときのイベントリスナー
       stars.forEach((star,index) => {
        star.addEventListener("click", () => {
            // すべての星の選択状態をリセット
            stars.forEach(s => s.classList.remove("selected"));
            // 選択された星まで選択状態を追加
            star.classList.add("selected");
            const starValue = star.getAttribute("data-value");
            evaluateInput.value =starValue;
            // 選択された星より前の星も選択状態にする
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add("selected");
            }
        });
       });
    });
</script>
@endsection