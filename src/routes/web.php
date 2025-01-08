<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ImageUploadController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*ユーザー登録*/
 Route::get('/register',[RegisterController::class, 'create'])->name('register');
 Route::post('/register',[RegisterController::class, 'store']);
 Route::get('/thanks',[RegisterController::class, 'thanks'])->name('thanks');

 /*ログイン*/
Route::get('/login',[LoginController::class, 'login']) ->name('login');
Route::post('/login',[LoginController::class, 'loginuser']);


/*店舗一覧、詳細ページ*/
Route::get('/',[ShopController::class, 'index'])->name('index');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('detail');
/*店舗検索*/
Route::get('/search', [ShopController::class, 'search'])->name('search.shop');
/*ソート機能*/
Route::get('/shops', [ShopController::class, 'sort'])->name('shops.index');
/*予約内容確認フォーム(detail.blade.php内に表示するため、viewファイルはなし)*/
Route::get('/confirm', [ReservationsController::class, 'confirm']);

/*左上メニュー*/
Route::get('/menu',[ShopController::class, 'menu']);

//管理者・店舗代表者　マルチログイン画面
Route::get('/multi/index', [AdminController::class, 'multiIndex'])->name('multiindex');
//マルチログイン処理（該当するアドレス、パスワードとセレクトボックスで管理者を選ぶとRoute::prefix('admin')の'/index'へ、
                   //店舗代表者を選ぶとRoute::prefix('manager')の'/index'へ移動）
Route::post('/multi/login', [AdminController::class, 'multiLogin']);

/*ログイン後*/
Route::group(['middleware' => ['auth']], function () {
  /*ログアウト*/
   Route::post('logout', [LoginController::class, 'logout'])->name('logout');

 /*予約処理*/
   Route::post('/detail',[ReservationsController::class, 'store'])->name('reserv.store');
   Route::get('/done',[ReservationsController::class, 'done'])->name('reserv.create');

 /*予約変更ページ*/
   Route::get('/mypage/{reservation_id}', [ReservationsController::class, 'edit'])->name('edit');
  /*予約変更ページ　入力内容確認フォーム*/
   Route::get('/edit/confirm', [ReservationsController::class, 'editconfirm']);
  /*予約変更処理*/
   Route::post('/edit/complete', [ReservationsController::class, 'reservationEdit']);

  /*予約取り消し*/
   Route::post('/reserv/{reservation_id}', [ReservationsController::class, 'delete'])->name('reserv.delete');
 /*マイページ*/
   Route::get('/mypage',[UsersController::class, 'mypage'])->name('mypage');
 /*お気に入り機能　登録/削除*/
   Route::post('/like/{shop_id}', [FavoriteController::class, 'create'])->name('like');
   Route::post('/unlike/{shop_id}', [FavoriteController::class, 'delete'])->name('unlike');
 /*口コミ投稿画面*/
   Route::get('/review/{shop_id}', [ReviewController::class, 'review'])->name('review');
   Route::post('/review/create', [ReviewController::class, 'reviewcreate']);
   /*口コミ削除*/
   Route::post('/detail/review/{id}', [ReviewController::class, 'markDelete'])->name('review.destroy'); // 削除処理
   
   //口コミ編集ページ
   Route::get('/review/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit'); // 編集画面表示
   //口コミ更新
   Route::post('/review/{id}', [ReviewController::class, 'update'])->name('review.update'); // 更新処理
  
   Route::post('/charge', [StripeController::class, 'charge'])->name('stripe');

   Route::get('/allimage', [ImageUploadController::class, 'index'])->name('image');
   Route::get('/create', [ImageUploadController::class, 'create']);
   Route::post('/image_upload', [ImageUploadController::class, 'store'])->name('image_upload');
});

//管理者操作枠                     （↓config/auth.php に'admin'を設定することで起動させる）
Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/index', [AdminController::class, 'adminindex'])->name('adminIndex');
    //管理者権限ログアウト
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::post('/create', [AdminController::class, 'admincreate']);
    //インポート処理実行画面
    Route::get('/shop', [AdminController::class, 'addShop'])->name('admin.addShop');
    Route::post('/create/shop', [AdminController::class, 'importCsv']);
    //登録店舗一覧を表示
    Route::get('/list', [AdminController::class, 'adminlist'])->name('admin.list');
    Route::get('/detail/{id}', [AdminController::class, 'shopdetail'])->name('admin.detail');
});

//店舗代表者操作枠                   （↓config/auth.php に'manager'を設定することで起動させる）
Route::prefix('manager')->middleware('verified:manager')->group(function() {
    Route::get('/index', [ManagerController::class, 'managerIndex'])->name('managerIndex');
    Route::get('/reservation/{store}', [ManagerController::class, 'managerReservation'])->name('managerReservation');
    Route::get('/new', [ManagerController::class, 'managerNew'])->name('managerNew');
    Route::post('/create', [ManagerController::class, 'managerCreate']);
    Route::get('/edit/{store}', [ManagerController::class, 'managerEdit'])->name('managerEdit');
    Route::post('/update', [ManagerController::class, 'managerUpdate']);
    Route::get('/show', [ManagerController::class, 'show']);
    Route::get('/show/edit', [ManagerController::class, 'showEdit']);
    Route::post('/upload', [ManagerController::class, 'managerUpload']);
});
  

      
















