<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    @yield('css')
</head>

<body class="body">
    <header class="header-page">
        
            <a href="/menu"><button class="menu-button" type="button"></button></a>
       
        <h1 class="header-logo">
            Rese
        </h1>
      
        
        <!--ソートセレクトボックス(並び順を変更)-->
        <select name="sort" id="sort-order" class="select-sort">
            <option selected disabled>並び替え:未選択</option>
            <option value="random" id="sort-random">ランダム</option>
            <option value="high" id="sort-high">評価が高い順</option>
            <option value="low" id="sort-low">評価が低い順</option>
        </select>

        <form class="header-list" action="/search" method="GET">
            @csrf
            
            <!--　エリア検索 -->
            <select name="area_id" id="">
                <option  selected disabled selected>All area</option>
             @foreach($areas as $area)
                <option value="{{ $area->id}}" @if( request('area_id')==$area->id ) selected @endif>{{ $area->name }}</option>
             @endforeach
            </select>
            <!-- ジャンル検索 -->
            <select name="genre_id" id="">
                <option selected disabled selected>All genre</option>
             @foreach($genres as $genre)
                <option value="{{ $genre->id }}" @if( request('genre_id')==$genre->id ) selected @endif>{{ $genre->name }}</option>>
             @endforeach
            </select>
            <input type="text" name="keyword" placeholder="検索" value="{{ request('keyword') }}">
            <input class="search-button" type="submit" value="検索">
            <input class="reset-button" type="submit" name="reset" value="リセット">
        </form>
    </header>

    <main class="main">
        @yield('main')
    </main>

<script>
//HTMLドキュメントの読み込みが完了し、DOMが構築された(画面が読み込まれた)時点でこの関数が実行
document.addEventListener('DOMContentLoaded', () => {
    // starToNumeric 関数を定義
    const starToNumeric = (stars) => {
        switch (stars) {
            case '★★★★★': return 5;
            case '★★★★☆': return 4;
            case '★★★☆☆': return 3;
            case '★★☆☆☆': return 2;
            case '★☆☆☆☆': return 1;
            default: return 0;
        }
    };

    //変数の初期化
    const shopList = document.getElementById('shop-list');   //（HTMLのid="shop-list"）
    const sortOrder = document.getElementById('sort-order');  //（HTMLのid="sort-order"）

    // 画像を読み込む関数   画像の非同期読み込みを行い、ロードが完了したらHTMLの<img>要素に画像を設定する。
    async function loadImage(src, imgElement) {
        return new Promise((resolve, reject) => {
            //画像の事前読み込み
            const img = new Image();
            //成功時
            img.onload = () => {
                imgElement.src = src; // 画像の読み込みに成功したら設定
                imgElement.style.opacity = 1;
                imgElement.style.transition = 'opacity 0.5s';
                resolve();
            };
            //失敗時
            img.onerror = (err) => {
                reject(new Error(`Failed to load image: ${src}`));
            };
            img.src = src;
        });
    }

    // APIから店舗データを取得する関数
    const fetchShops = async (sort) => {
        try {    //fetch()で /shops エンドポイントにGETリクエストを送信。sortパラメータをURLに追加してソート順を指定
            const response = await fetch(`/shops?sort=${encodeURIComponent(sort)}`, {
                method: 'GET',
                headers: { 'Content-type': 'application/json' },
            });
            if (!response.ok) {
              throw new Error(`Error fetching shops: ${response.statusText}`);
            }
            //response.json() でレスポンスデータをJSON形式に変換
            const responseData = await response.json();

            //データが空 (length === 0) もしくは無効ならメッセージを表示し、終了
            if (!responseData || !Array.isArray(responseData) || responseData.length === 0) {
              shopList.innerHTML = '<p>表示する店舗がありません。</p>';
              return;
            }
            displayShops(responseData); // APIデータを関数に渡す
        } catch (error) {
            console.error('Error fetching shops:', error);
            shopList.innerHTML = `<p>${error.message || 'エラーが発生しました。'}</p>`;
        }
    };

    // 取得した店舗データをHTML要素としてページに表示
    const displayShops = (shops) => {
        //HTML要素生成
        shopList.innerHTML = ''; // リストをリセット
        
        shops.forEach(async (shop) => {
            
            // 店舗画像、名前、エリアタグ、ジャンルタグ、ボタン、いいねボタンなどをHTML文字列として生成
            const shopElement = document.createElement('div');
            shopElement.className = 'shop';
            // 画像パスを条件で切り替え
            const imagePath = shop.image.startsWith('https://') || shop.image.startsWith('https://') 
              ? shop.image 
              : `/storage/${shop.image}`;

            shopElement.innerHTML = `
                <div class="shop-photo">
                    <img class="shop-img" src="${imagePath}" style="opacity: 0;" alt="店舗写真">
                </div>
                <div class="shop-content">
                    <h1 class="shop-title">${shop.shop_name}</h1>
                    <div class="place-category">
                        <p class="shop-tag">#${shop.area_name}</p>
                        <p class="shop-tag">#${shop.genre_name}</p>
                    </div>
                    <div class="detail-and-like">
                        <div class="detail-side">
                            <a href="/detail/${shop.id}">
                                <button class="in-detail" type="button">詳しく見る</button>
                            </a>
                        </div>
                        <div class="like-side">
                            ${    //shop.likesの有無で「いいね状態」か「未いいね状態」かを切り替える
                                shop.likes 
                                    ? `<form class="like-or-unlike" action="/like/${shop.id}" method="POST">
                                        <input class="like-icon" type="image" src="/img/unlike.png" width="32px" height="32px" alt="いいね">
                                    </form>`
                                    : `<form class="like-or-unlike" action="/unlike/${shop.id}" method="POST">
                                        <input class="like-icon" type="image" src="/img/like.png" width="32px" height="32px">
                                    </form>`
                            }
                        </div>
                    </div>
                </div>
            `;
            shopList.appendChild(shopElement);

            // 画像の読み込み処理
            const imgElement = shopElement.querySelector('.shop-img');
            const imageSrc = shop.image ? `${imagePath}?t=${Date.now()}` : '/img/default.png';
           
            //loadImage()関数で画像を読み込み、エラー時にはデフォルト画像を設定
            try {
                if (!shop.image) {
                     throw new Error('No image path provided');
                }
                await loadImage(imageSrc, imgElement); // 画像の非同期ロード
                imgElement.style.opacity = 1; // 表示
            } catch (err) {
                console.error(`Error loading image for shop ${shop.shop_name}:`, err);
                imgElement.src = '/img/default.png'; // エラー時はデフォルト画像にフォールバック
                imgElement.style.opacity = 1; // フォールバック画像を表示
            }
        });
    };

    // 並び替えセレクトボックスの値が変更された際に、店舗データを再取得・再表示
    sortOrder.addEventListener('change', async (event) => {
        const sort = event.target.value;
        await fetchShops(sort);
    });

    // 初期ロード
    const initialSort = sortOrder.value || 'high';
    fetchShops(initialSort);
});
</script>

</body>
</html>