<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Member;
use App\Http\Controllers\MemberJoinController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/committee', [PageController::class, 'committee'])->name('committee');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/join', [MemberJoinController::class, 'create'])->name('join');
Route::post('/join', [MemberJoinController::class, 'store'])->name('join.store');

/*
|--------------------------------------------------------------------------
| Member area
|--------------------------------------------------------------------------
*/
Route::prefix('member')->name('member.')->group(function () {
    Route::get('login', [Member\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Member\AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [Member\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:member')->group(function () {
        Route::get('/', [Member\DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile', [Member\DashboardController::class, 'editProfile'])->name('profile.edit');
        Route::put('profile', [Member\DashboardController::class, 'updateProfile'])->name('profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.attempt');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::post('committee/reorder', [Admin\CommitteeController::class, 'reorder'])->name('committee.reorder');
        Route::resource('committee', Admin\CommitteeController::class)->except('show');
        Route::resource('news', Admin\NewsController::class)->except('show');
        Route::resource('events', Admin\EventController::class)->except('show');
        Route::resource('funds', Admin\FundTransactionController::class)->except('show');

        Route::get('media', [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('media', [Admin\MediaController::class, 'store'])->name('media.store');
        Route::put('media/{medium}', [Admin\MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{medium}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('members', [Admin\MemberController::class, 'index'])->name('members.index');
        Route::get('members/{member}', [Admin\MemberController::class, 'show'])->name('members.show');
        Route::delete('members/{member}', [Admin\MemberController::class, 'destroy'])->name('members.destroy');

        Route::get('settings', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
    });
});
