<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ScreeningCalendarController as ScreeningCalendarController;
use App\Http\Controllers\User\ScreeningCalendarController as UserCalendarController;

Route::get('/', function () {
    return view('index');
})->name('index');


/**
 * ユーザー認証関連のルート
 * Laravel標準のAuth::routes()を使用せず、ログイン・ログアウト処理をカスタマイズ
 */
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(UserCalendarController::class)->prefix('user')->name('user.')
    ->middleware('auth')->group(function () {
        Route::get('screenings/calendar', 'index')->name('screenings.calendar.index');
});

// ------------------------------------------------------------------------------------------------
/**
 * 管理者認証関連のルート
 * 管理者専用のログイン処理を設定
 */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/admin', function () {
    return view('admin.index');
})->middleware('auth:admin')->name('admin.index');

Route::controller(MovieController::class)->prefix('admin')->name('admin.')
    ->middleware('auth:admin')->group(function () {
        Route::get('movies/', 'index')->name('movies.index');
});

Route::controller(ScreeningCalendarController::class)->prefix('admin')->name('admin.')
    ->middleware('auth:admin')->group(function () {
        Route::get('screenings/calendar', 'index')->name('screenings.calendar.index');

        // カレンダーイベントの取得API
        Route::get('screenings/calendar/events', 'events')->name('screenings.calendar.events');

        // 上映スケジュールの詳細ページ
        Route::get('screenings/{screening}', 'show')->name('screenings.show');
});