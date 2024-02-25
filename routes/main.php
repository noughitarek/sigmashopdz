<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\main\MainController;


Route::name('main_')->controller(MainController::class)->group(function() {
    Route::get('', 'index')->name('index');
    Route::name('pages_')->prefix('pages')->group(function(){
        Route::get('{page}', 'page')->name('show');
    });
    Route::name('products_')->prefix('products')->group(function(){
        Route::get('{product}', 'product')->name('show');
        Route::post('{product}/order', 'order')->name('order');
    });
    Route::name('categories_')->prefix('categories')->group(function(){
        Route::get('{category}', 'category')->name('show');
    });
});