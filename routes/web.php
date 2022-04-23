<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [HomeController::class,'home'])->name('home');
Route::group(['prefix'=>'/donate'],function() {
    Route::get('/',[HomeController::class,'donate'])->name('donate');
    Route::get('/success',[HomeController::class,'success'])->name('donate.success');
    Route::post('/',[HomeController::class,'process'])->name('donate.process');
});

Route::group(['prefix'=>'/products'],function() {
    Route::get('/',[ProductController::class,'index'])->name('products');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // auth routes
});
