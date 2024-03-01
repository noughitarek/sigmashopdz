<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\webmaster\AdminController;
use App\Http\Controllers\webmaster\StockController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\webmaster\WilayaController;
use App\Http\Controllers\webmaster\MessageController;
use App\Http\Controllers\webmaster\ProductController;
use App\Http\Controllers\webmaster\ProfileController;
use App\Http\Controllers\webmaster\SettingController;
use App\Http\Controllers\webmaster\CampaignController;
use App\Http\Controllers\webmaster\CategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\webmaster\AttributeController;
use App\Http\Controllers\webmaster\DashboardController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;


Route::middleware('auth')->name('webmaster_')->namespace('App\Http\Controllers\webmaster')->prefix("webmaster")->group(function() {
    Route::middleware('permission:consult_dashboard')->name('dashboard_')->controller(DashboardController::class)->prefix('dashboard')->group(function(){
        Route::get('', 'index')->name('index');
    });
    Route::middleware('permission:consult_campaigns')->name('campaigns_')->controller(CampaignController::class)->prefix('campaigns')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_campaigns');
        Route::post('create', 'store')->name('store')->middleware('permission:create_campaigns');
        Route::get('{campaign}', 'show')->name('show');
        Route::get('{campaign}/edit', 'edit')->name('edit')->middleware('permission:edit_campaigns');
        Route::put('{campaign}/edit', 'update')->name('update')->middleware('permission:edit_campaigns');
        Route::delete('{campaign}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_campaigns');
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
    Route::middleware('permission:consult_attributes')->name('attributes_')->controller(AttributeController::class)->prefix('attributes')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_attributes');
        Route::post('create', 'store')->name('store')->middleware('permission:create_attributes');
        Route::get('{attribute}', 'show')->name('show');
        Route::get('{attribute}/edit', 'edit')->name('edit')->middleware('permission:edit_attributes');
        Route::put('{attribute}/edit', 'update')->name('update')->middleware('permission:edit_attributes');
        Route::delete('{attribute}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_attributes');
    });
    Route::middleware('permission:consult_pages')->name('pages_')->controller(PageController::class)->prefix('pages')->group(function(){
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
        Route::post('{order}/confirm', 'confirm')->name('confirm')->middleware('permission:confirm_orders');
        Route::get('{order}/shipp', 'shipp')->name('shipp')->middleware('permission:shipp_orders');
        Route::get('{order}/validate', 'Validate_order')->name('validate')->middleware('permission:validate_orders');
        Route::post('{order}/add_information', 'add_information')->name('add_information')->middleware('permission:add_information_orders');
        Route::get('{order}/archive', 'archive')->name('archive')->middleware('permission:archive_orders');
        Route::get('{order}/edit', 'edit')->name('edit')->middleware('permission:edit_orders');
        Route::put('{order}/edit', 'update')->name('update')->middleware('permission:edit_orders');
    });
    Route::middleware('permission:consult_messages')->name('messages_')->controller(MessageController::class)->prefix('messages')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('{message}', 'show')->name('show');
        Route::delete('{message}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_messages');
    });
    Route::middleware('permission:consult_stock')->name('stock_')->controller(StockController::class)->prefix('stock')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_stock');
        Route::post('create', 'store')->name('store')->middleware('permission:create_stock');
        Route::get('{stock}', 'show')->name('show');
        
        Route::get('{product}/create', 'create_for_product')->name('create_for_product')->middleware('permission:create_stock');
        Route::post('{product}/create', 'store_for_product')->name('store_for_product')->middleware('permission:create_stock');

        Route::get('{stock}/edit', 'edit')->name('edit')->middleware('permission:edit_stock');
        Route::put('{stock}/edit', 'update')->name('update')->middleware('permission:edit_stock');
        Route::delete('{stock}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_stock');
    });
    Route::middleware('permission:consult_delivery')->name('delivery_')->controller(WilayaController::class)->prefix('delivery')->group(function(){
        Route::get('', 'index')->name('index');
        Route::put('edit', 'update')->name('update')->middleware('permission:edit_delivery');
        Route::get('update_api', 'update_api')->name('api')->middleware('permission:edit_delivery');
    });
    Route::middleware('permission:consult_admins')->name('admins_')->controller(AdminController::class)->prefix('admins')->group(function(){
        Route::get('', 'index')->name('index');
        Route::get('create', 'create')->name('create')->middleware('permission:create_admins');
        Route::post('create', 'store')->name('store')->middleware('permission:create_admins');
        Route::get('{admin}', 'show')->name('show');
        Route::get('{admin}/edit', 'edit')->name('edit')->middleware('permission:edit_admins');
        Route::get('{admin}/role/edit', 'edit')->name('role_edit')->middleware('permission:edit_role_admins');
        Route::put('{admin}/edit', 'update')->name('update')->middleware('permission:edit_admins');
        Route::get('{admin}/payement', 'payement')->name('payement')->middleware('permission:make_payement_admins');
        Route::post('{admin}/payement', 'payement_store')->name('payement_store')->middleware('permission:make_payement_admins');
        Route::delete('{admin}/destroy', 'destroy')->name('destroy')->middleware('permission:delete_admins');
    });
    Route::middleware('permission:consult_settings')->name('settings_')->controller(SettingController::class)->prefix('settings')->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('edit', 'edit')->name('edit')->middleware('permission:edit_settings');
    });
    Route::name('profile_')->controller(ProfileController::class)->prefix('profile')->group(function(){
        Route::get('', 'index')->name('index');
        Route::post('edit', 'update')->name('edit');
        Route::put('password/edit', 'password_edit')->name('password_edit');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


Route::middleware('guest')->name('webmaster_')->prefix("webmaster")->group(function() {
    Route::get('', [AuthenticatedSessionController::class, 'create']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});