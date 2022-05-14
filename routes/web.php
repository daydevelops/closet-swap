<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
use Laravel\Jetstream\Jetstream;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // auth routes
});


Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    $authMiddleware = config('jetstream.guard')
            ? 'auth:'.config('jetstream.guard')
            : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
            ? config('jetstream.auth_session')
            : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware, 'verified']))], function () {
        Route::get('/user/settings', [UserController::class, 'settings'])->name('profile.show');
    });
});


Route::get('/', [HomeController::class,'home'])->name('home');
Route::group(['prefix'=>'/donate'],function() {
    Route::get('/',[HomeController::class,'donate'])->name('donate');
    Route::get('/success',[HomeController::class,'success'])->name('donate.success');
    Route::post('/',[HomeController::class,'process'])->name('donate.process');
});

Route::group(['prefix'=>'/profile'],function() {
    Route::get('/{user}',[ProfileController::class,'show'])->name('profile.visit');
});

Route::group(['prefix'=>'/products'],function() {
    Route::get('/',[ProductController::class,'index'])->name('products');
    Route::get('/create',[ProductController::class,'create'])->name('products.create');
    Route::get('/{product}',[ProductController::class,'show'])->name('products.show');
    Route::get('/{product}/edit',[ProductController::class,'edit'])->middleware('auth')->name('products.edit');
    Route::patch('/{product}',[ProductController::class,'update'])->middleware('auth')->name('products.update');

    Route::post('/like/{product}',[LikeController::class,'store'])->middleware('auth')->name('products.like');
    Route::delete('/unlike/{product}',[LikeController::class,'destroy'])->middleware('auth')->name('products.unlike');
});

Route::group(['prefix'=>'/search'],function() {
    Route::get('/tag/{tag}',[SearchController::class,'tag'])->name('search.tag');
});