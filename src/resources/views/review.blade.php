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
           @if (Str::startsWith($shops->image, 'https://'))
             <img class="shop-img" src="{{ $shops->image }}" alt="店舗写真"  >
           @else
             <img class="shop-img" src="{{ Storage::url($shops->image) }}" alt="店舗写真">
           @endif
         </div>
         <div class="shop-content">
            <div>
              <h1 class="shop-title">{{ $shops->shop_name }}</h1>
            </div>
        
            <div class="place-category">
               <p class="shop-tag">#{{ $shops->area->name }}</p>
               <p class="shop-tag">#{{ $shops->genre->name }}</p>
            </div>

            
               <a href="{!! '/detail/' . $shops->id !!}">
                  <button class="in-detail"  type="button">詳しく見る</button>
               </a>
           
         </div>
     </div>
  </div>

  <div class="main">
    <form action="/review/create" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="shop-name">
            <h1>体験を評価してください</h1>
            <input type="hidden" name="shop_id" value="{{ $shops['id'] }}">
        </div>

        <!-- 星の数セレクト -->
        <div class="review-star">
            <span class="star" data-value="★☆☆☆☆">★</span>
            <span class="star" data-value="★★☆☆☆">★</span>
            <span class="star" data-value="★★★☆☆">★</span>
            <span class="star" data-value="★★★★☆">★</span>
            <span class="star" data-value="★★★★★">★</span>
            <input type="hidden" name="evaluate" id="evaluate" value="">
            <div class="form-error2">
                @error('evaluate')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-comment">
            <h3><label for="text">口コミを投稿(400字まで入力可)</label></h3>
            <textarea class="review-comment-field" name="review_comment" id="text" placeholder="カジュアルな夜のお出掛けにおすすめのスポット"></textarea>
            <div class="form-error2">
                @error('review_comment')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-image">
          <h3 class="add-image"><label for="image">画像の追加 (JPEG, PNGのみ)</label></h3>
          
            @error('image')
              <div class="form-error2">{{ $message }}</div>
            @enderror
            &emsp;
            <!-- 画像プレビュー用 -->
            <div class="image-preview" id="image-preview">
                <input class="input-image" type="file" name="image" id="image" accept="image/jpeg, image/png" hidden>
                <img id="preview" src="" alt="プレビュー画像" style="display: none;">
                <p class="placeholder-text">クリックして写真を追加</p>
            </div>
        </div>

   </div>
   <div class="review-create-button">
       <button class="submit"  type="submit" onclick="return confirm('この内容で投稿しますか？')">口コミを投稿</button>
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