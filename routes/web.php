<?php

use App\Http\Admin\Controllers\PostController;
use App\Http\Admin\Controllers\SocialMediaAccountController;
use App\Http\Admin\Controllers\SocialMediaController;
use App\Http\Auth\Controllers\UpdatePasswordController;
use App\Http\Auth\Controllers\LoginController;
use App\Http\Instagram\InstagramController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'index')->name('index');

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function ()
{
    Route::prefix('admin')->name('admin.')->group(function ()
    {
        Route::patch('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('password', [UpdatePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [UpdatePasswordController::class, 'update'])->name('password.update');
        Route::get('/', [SocialMediaAccountController::class, 'index'])->name('index');

        Route::prefix('accounts/{account}')->name('accounts.')->group(function ()
        {
            Route::resource('posts', PostController::class)->only(['create', 'store', 'destroy']);
        });

        Route::resource('accounts', SocialMediaAccountController::class)->except(['show', 'create', 'edit', 'update']);
        Route::resource('socialMedias', SocialMediaController::class)->only(['index', 'update'])
            ->parameters([
                'socialmedia' => 'socialMedia',
            ]);

        Route::prefix('social-medias/{socialMedia}')->name('socialMedias.')->group(function ()
        {
            Route::name('synchronize')->get('synchronize', [SocialMediaController::class, 'synchronize']);
        });

        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    });

    Route::prefix('instagram')->name('instagram.')->group(function ()
    {
        Route::get('login/{account}', [InstagramController::class, 'login'])->name('login');

        Route::get('redirect', [InstagramController::class, 'redirect'])->name('redirect');
    });
});





