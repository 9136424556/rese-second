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

            <div class="detail-side">
               <a href="{!! '/detail/' . $shops->id !!}">
                  <button class="in-detail"  type="button">詳しく見る</button>
               </a>
            </div>  
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
            <select class="select-stars" name="evaluate" >
                <option value="" hidden>星の数を選んでください</option>
                @foreach($stars as $star)
                <option value="{{ $star['star'] }}">{{ $star['star'] }}</option>
                @endforeach
            </select>
            <div class="form-error">
                @error('evaluate')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-comment">
            <p><label for="text">口コミを投稿(400字まで入力可)</label></p>
            <textarea class="review-comment-field" name="review_comment" id="text" placeholder="カジュアルな夜のお出掛けにおすすめのスポット"></textarea>
            <div class="form-error">
                @error('review_comment')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-image">
          <label for="image">画像の追加 (JPEG, PNGのみ)</label>
          
            @error('image')
              <div class="form-error">{{ $message }}</div>
            @enderror
            &emsp;
            <!-- 画像プレビュー用 -->
            <div class="image-preview" id="image-preview">
                <input class="input-image" type="file" name="image" id="image" accept="image/jpeg, image/png" hidden>
                <img id="preview" src="" alt="プレビュー画像" style="display: none;">
                <p class="placeholder-text">クリックして写真を追加</p>
            </div>
        </div>

       
    </form>
  </div>
   <div class="review-create-button">
       <button class="submit"  type="submit" onclick="return confirm('この内容で投稿しますか？')">口コミを投稿</button>
   </div>
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
</script>
@endsection