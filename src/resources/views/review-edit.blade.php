@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviewEdit.css') }}">
@endsection

@section('main')
<!--店舗詳細ページに戻る-->

    <button class="rebirth-button"><a href="{{ route('detail', $review->shop_id) }}" class="btn btn-secondary">＜</a></button>

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
            <select class="select-stars" name="evaluate" >
                <option value="" hidden>星の数を選んでください</option>
                @foreach($stars as $star)
                <option value="{{ $star['star'] }}" {{ $review->evaluate == $star['star'] ? 'selected' : '' }}>
                   {{ $star['star'] }}
                </option>
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
            <textarea class="review-comment-field" name="review_comment" placeholder="コメントを記入してください">
                {{ old('review_comment', $review->review_comment) }}
            </textarea>
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
                <img id="preview" src="" alt="プレビュー画像" style="display: none;">
                <p class="placeholder-text">クリックして写真を追加</p>
            </div>
            
        </div>

        <div class="review-create-button">
            <button class="submit"  type="submit">口コミを投稿</button>
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
</script>
@endsection