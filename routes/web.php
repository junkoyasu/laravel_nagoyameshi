<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ReservationController;

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

Route::get('/',  [WebController::class, 'index'])->name('top');

Route::controller(UserController::class)->group(function () {
    Route::get('users/mypage', 'mypage')->name('mypage');
    Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
    Route::put('users/mypage', 'update')->name('mypage.update');
    Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
     Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
     Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
     Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
     Route::get('users/mypage/register_card', 'register_card')->name('mypage.register_card');
     Route::post('users/mypage/token', 'token')->name('mypage.token');
});

Route ::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('shops/{shop}/favorite', [ShopController::class, 'favorite'])->name('shops.favorite');
Route::resource('shops', ShopController::class)->middleware(['auth', 'verified']);
 Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('shops.reservations', ReservationController::class)->only(['index', 'create', 'store','destroy']);
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


Route::post('users/mypage/subscribe', [UserController::class, 'subscribe'])->name('mypage.subscribe');
Route::post('users/mypage/unsubscribe', [UserController::class, 'unsubscribe'])->name('mypage.unsubscribe');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
// Route::get('/search2', [ShopController::class, 'search2'])->name('shop.search2');
/*Route::get('shops.reservations', ReservationController::class)->name('index');
Route::get('shops.reservations', ReservationController::class)->name('create');
Route::get('shops.reservations', ReservationController::class)->name('store');
Route::get('shops.reservations', ReservationController::class)->name('destroy');*/
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    
});
