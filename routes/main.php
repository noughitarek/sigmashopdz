<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\main\MainController;


Route::name('main_')->controller(MainController::class)->group(function() {
    Route::get('', 'index')->name('index');

    Route::name('pages_')->prefix('pages')->group(function(){
    
        Route::get('contact', 'contact')->name('contact');
        Route::post('contact', 'contact_store')->name('contact_store');
        Route::get('echange', 'echange')->name('echange');
        Route::post('echange', 'echange_store')->name('echange_store');
        Route::get('tracking', 'tracking_orders')->name('tracking');
        Route::post('tracking', 'tracking_lookup')->name('tracking_lookup');
        Route::get('{page}', 'page')->name('show');
    });
    Route::name('products_')->prefix('products')->group(function(){
        Route::get('{product}', 'product')->name('show');
        Route::post('{product}/order', 'order')->name('order');
    });
    Route::name('orders_')->prefix('orders')->group(function(){
        Route::get('{order}/tracking', 'tracking')->name('tracking');
        Route::get('{order}/thankyou', 'thankyou')->name('thankyou');
    });
});