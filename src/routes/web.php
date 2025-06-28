<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\ScreeningCalendarController as ScreeningCalendarController;
use App\Http\Controllers\User\ScreeningCalendarController as UserCalendarController;
use App\Http\Controllers\User\SeatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;

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

        // カレンダーイベントの取得API
        Route::get('screenings/calendar/events', 'events')->name('screenings.calendar.events');
        // 上映スケジュールの詳細ページ
        Route::get('screenings/{screening}', 'show')->name('screenings.show');
});

Route::controller(SeatController::class)->prefix('user')->name('user.')
    ->middleware('auth')->group(function () {
        Route::post('/seat/reserve', 'reserve')->name('seat.reserve');
        Route::get('/seat/reserve/completed', 'completed')->name('seat.reserve.completed');
        Route::delete('/seat/cancel', 'cancel')->name('seat.cancel');
        Route::get('/seat/reserve-list', 'reserveList')->name('seat.reserve-list');
        Route::get('/seat/reserve/{id}/export-pdf', 'exportPdf')->name('seat.reserve.export-pdf');
});

// ------------------------------------------------------------------------------------------------
/**
 * 管理者認証関連のルート
 * 管理者専用のログイン処理を設定
 */
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// 2段階認証処理用のルート
Route::get('/admin/login/second', [AdminLoginController::class, 'showSecondLogin'])->name('admin.secondLogin');
Route::post('/admin/login/secondAuth', [AdminLoginController::class, 'secondAuth'])->name('admin.secondAuth');

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/notifications/send', 'sendNotification')->name('notifications.send');
    });

    Route::controller(MovieController::class)->group(function () {
        Route::get('movies/', 'index')->name('movies.index');
        Route::get('movies/create', 'create')->name('movies.create');
        Route::post('movies/store', 'store')->name('movies.store');
        Route::get('movies/{id}', 'show')->name('movies.show');
        Route::delete('movies/{id}', 'destroy')->name('movies.destroy');
    });

    Route::controller(ScreeningCalendarController::class)->group(function () {
        Route::get('screenings/calendar', 'index')->name('screenings.calendar.index');
        Route::get('screenings/calendar/events', 'events')->name('screenings.calendar.events');
        Route::get('screenings/{screening}', 'show')->name('screenings.show');
        Route::get('screening/create/{movie_id}', 'create')->name('screenings.create');
        Route::post('screening/store', 'store')->name('screenings.store');
    });

    Route::controller(AdminUserController::class)->group(function () {
        Route::get('users', 'index')->name('users.index');
        Route::get('users/create', 'create')->name('users.create');
    });
});
// ------------------------------------------------------------------------------------------------