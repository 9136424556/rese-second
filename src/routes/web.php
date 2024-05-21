<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ForgotPasswordLinkController;


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


Route::get('/register',[RegisterController::class, 'create']);
Route::post('/register',[RegisterController::class, 'storeuser'])->name('register');
Route::post('/logout', [LogoutController::class, 'destroy'])->middleware('auth');
Route::post('/forgot-password', [ForgotPasswordLinkController::class, 'store']);
Route::post('/forgot-password/{token}', [ForgotPasswordController::class, 'reset']);


Route::get('/thanks',[RegisterController::class, 'thanks'])->name('thanks');


Route::get('/login',[RegisterController::class, 'login'])->name('login');
Route::post('/login',[RegisterController::class, 'loginuser'])->middleware('guest');

Route::get('/',[ShopController::class, 'index'])->name('index');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('detail.get');
Route::post('/detail',[ShopController::class, 'store'])->name('reserv.store');

Route::get('/done',[ShopController::class, 'done'])->name('reserv.create');

Route::get('/menu',[ShopController::class, 'menu']);

Route::get('/mypage/{user_id}',[ShopController::class, 'mypage'])->name('login.mypage');
