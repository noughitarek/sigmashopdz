<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Webmaster\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\webmaster\ProductController;
use App\Http\Controllers\webmaster\CategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;


Route::middleware('auth')->name('webmaster_')->namespace('App\Http\Controllers\webmaster')->prefix("webmaster")->group(function() {
    Route::middleware('permission:consult_dashboard')->name('dashboard_')->controller(CategoryController::class)->prefix('dashboard')->group(function(){
        Route::get('', 'index')->name('index');
    });
    Route::middleware('permission:consult_categories')->name('categories_')->controller(CategoryController::class)->prefix('categories')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_categories');
        Route::post('create', 'store')->name('store')->middleware('permission:create_categories');
        Route::get('{category}', 'show')->name('show');
        Route::get('{category}/edit', 'edit')->name('edit')->middleware('permission:edit_categories');
        Route::put('{category}/edit', 'update')->name('update')->middleware('permission:edit_categories');
        Route::delete('{category}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_categories');
    });
    Route::middleware('permission:consult_products')->name('products_')->controller(ProductController::class)->prefix('products')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_products');
        Route::post('create', 'store')->name('store')->middleware('permission:create_products');
        Route::get('{product}', 'show')->name('show');
        Route::get('{product}/edit', 'edit')->name('edit')->middleware('permission:edit_products');
        Route::put('{product}/edit', 'update')->name('update')->middleware('permission:edit_products');
        Route::delete('{product}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_products');
    });
    Route::middleware('permission:consult_pages')->name('pages_')->controller(CategoryController::class)->prefix('pages')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_pages');
        Route::post('create', 'store')->name('store')->middleware('permission:create_pages');
        Route::get('{page}', 'show')->name('show');
        Route::get('{page}/edit', 'edit')->name('edit')->middleware('permission:edit_pages');
        Route::put('{page}/edit', 'update')->name('update')->middleware('permission:edit_pages');
        Route::delete('{page}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_pages');
    });
    Route::name('orders_')->controller(OrderController::class)->prefix('orders')->group(function(){
        Route::get('', 'index')->name('all_index')->middleware('permission:consult_all_orders');
        Route::get('pending', 'pending_index')->name('pending_index')->middleware("permission:consult_pending_orders");
        Route::get('shipped', 'shipped_index')->name('shipped_index')->middleware("permission:consult_shipped_orders");
        Route::get('delivered', 'delivered_index')->name('delivered_index')->middleware("permission:consult_delivered_orders");
        Route::get('back', 'back_index')->name('back_index')->middleware("permission:consult_back_orders");
        Route::get('archived', 'archived_index')->name('archived_index')->middleware("permission:consult_archived_orders");
        Route::get('{order}', 'show')->name('show');
        Route::get('{order}/edit', 'edit')->name('edit')->middleware('permission:edit_orders');
        Route::put('{order}/edit', 'update')->name('update')->middleware('permission:edit_orders');
    });
    Route::middleware('permission:consult_messages')->name('messages_')->controller(CategoryController::class)->prefix('messages')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_messages');
        Route::post('create', 'store')->name('store')->middleware('permission:create_messages');
        Route::get('{message}', 'show')->name('show');
        Route::get('{message}/edit', 'edit')->name('edit')->middleware('permission:edit_messages');
        Route::put('{message}/edit', 'update')->name('update')->middleware('permission:edit_messages');
        Route::delete('{message}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_messages');
    });
    Route::middleware('permission:consult_stock')->name('stock_')->controller(CategoryController::class)->prefix('stock')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_stock');
        Route::post('create', 'store')->name('store')->middleware('permission:create_stock');
        Route::get('{stock}', 'show')->name('show');
        Route::get('{stock}/edit', 'edit')->name('edit')->middleware('permission:edit_stock');
        Route::put('{stock}/edit', 'update')->name('update')->middleware('permission:edit_stock');
        Route::delete('{stock}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_stock');
    });
    Route::middleware('permission:consult_delivery')->name('delivery_')->controller(CategoryController::class)->prefix('delivery')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_delivery');
        Route::post('create', 'store')->name('store')->middleware('permission:create_delivery');
        Route::get('{delivery}', 'show')->name('show');
        Route::get('{delivery}/edit', 'edit')->name('edit')->middleware('permission:edit_delivery');
        Route::put('{delivery}/edit', 'update')->name('update')->middleware('permission:edit_delivery');
        Route::delete('{delivery}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_delivery');
    });
    Route::middleware('permission:consult_admins')->name('admins_')->controller(CategoryController::class)->prefix('admins')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_admins');
        Route::post('create', 'store')->name('store')->middleware('permission:create_admins');
        Route::get('{admin}', 'show')->name('show');
        Route::get('{admin}/edit', 'edit')->name('edit')->middleware('permission:edit_admins');
        Route::put('{admin}/edit', 'update')->name('update')->middleware('permission:edit_admins');
        Route::delete('{admin}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_admins');
    });
    Route::middleware('permission:consult_settings')->name('settings_')->controller(CategoryController::class)->prefix('settings')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_settings');
        Route::post('create', 'store')->name('store')->middleware('permission:create_settings');
        Route::get('{setting}', 'show')->name('show');
        Route::get('{setting}/edit', 'edit')->name('edit')->middleware('permission:edit_settings');
        Route::put('{setting}/edit', 'update')->name('update')->middleware('permission:edit_settings');
        Route::delete('{setting}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_settings');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


Route::middleware('guest')->name('webmaster_')->prefix("webmaster")->group(function() {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

});