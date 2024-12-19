@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('main')
<!--店舗詳細ページに戻る-->
<div class="back-button">
    <a href="{{ route('detail', $shops->id) }}" class="btn btn-secondary">＜</a>
</div>
<div class="main">
    <form action="/review/create" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="shop-name">
            <h1>{{ $shops->shop_name}}</h1>
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
            <textarea class="review-comment-field" name="review_comment" placeholder="コメントを記入してください"></textarea>
            <div class="form-error">
                @error('review_comment')
                {{ $message }}
                @enderror
                &emsp;
            </div>
        </div>

        <div class="review-image">
          <label for="image">画像をアップロード (JPEG, PNGのみ)</label>
          <input type="file" name="image" id="image" accept="image/jpeg, image/png">
            @error('image')
              <div class="form-error">{{ $message }}</div>
            @enderror
            &emsp;
            <!-- 画像プレビュー用 -->
            <div class="image-preview">
                <img id="preview" src="" alt="プレビュー画像" style="display: none;">
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

        // ファイルが存在し、画像ファイルである場合
        if (file && (file.type === 'image/jpeg' || file.type === 'image/png')) {
            const reader = new FileReader(); // FileReaderを使って画像を読み込む
            reader.onload = function(e) {
                preview.src = e.target.result; // imgタグのsrcに画像データをセット
                preview.style.display = 'block'; // プレビュー画像を表示
            };
            reader.readAsDataURL(file); // ファイルをDataURLとして読み込む
        } else {
            // ファイルが指定フォーマット以外の場合、エラーメッセージを表示
            alert('JPEGまたはPNG形式の画像をアップロードしてください。');
            preview.src = ''; // プレビューをクリア
            preview.style.display = 'none';
            event.target.value = ''; // inputの選択をリセット
        }
    });
</script>
@endsection