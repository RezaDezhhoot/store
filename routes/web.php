<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
/*
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

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/',\App\Http\Livewire\Site\Home\IndexHome::class)->name('home');
Route::get('/about',\App\Http\Livewire\Site\Settings\IndexAbout::class)->name('about');
Route::get('/contact',\App\Http\Livewire\Site\Settings\IndexContact::class)->name('contact');
Route::get('/faq',\App\Http\Livewire\Site\Settings\IndexFaq::class)->name('faq');
Route::get('/policy',\App\Http\Livewire\Site\Settings\IndexPolicy::class)->name('policy');
Route::get('/shop/{category?}',\App\Http\Livewire\Site\Store\IndexStore::class)->name('shop');
Route::get('/product/{slug}',\App\Http\Livewire\Site\Store\SingleProduct::class)->name('product');
Route::get('/articles',\App\Http\Livewire\Site\Articles\IndexArticles::class)->name('articles');
Route::get('/articles/{slug}',\App\Http\Livewire\Site\Articles\SingleArticles::class)->name('article');
Route::get('/cart',\App\Http\Livewire\Site\Carts\IndexCart::class)->name('cart');
Route::middleware('auth')->get('/checkout/{gateway?}',\App\Http\Livewire\Site\Carts\IndexCheckout::class)->name('checkout');
Route::middleware('auth')->get('/payment',\App\Http\Livewire\Site\Carts\IndexPayment::class)->name('payment');

Route::middleware(['auth','role:admin','schedule'])->namespace('App\Http\Livewire\Admin')->prefix('/admin')->group(function (){
    Route::get('/dashboard', Dashboard\indexDashboard::class)->name('admin.dashboard');
    Route::get('/profile', Profile\IndexProfile::class)->name('admin.profile');
    Route::get('/orders', Orders\IndexOrder::class)->name('admin.order');
    Route::get('/orders/{action}/{id?}', Orders\StoreOrder::class)->name('admin.store.order');
    Route::get('/refunds', Refunds\IndexRefund::class)->name('admin.refund');
    Route::get('/refunds/{action}/{id?}', Refunds\StoreRefund::class)->name('admin.store.refund');
    Route::get('/tickets', Tickets\IndexTicket::class)->name('admin.ticket');
    Route::get('/tickets/{action}/{id?}', Tickets\StoreTicket::class)->name('admin.store.ticket');
    Route::get('/comments', Comments\IndexComment::class)->name('admin.comment');
    Route::get('/comments/{action}/{id?}', Comments\StoreComment::class)->name('admin.store.comment');
    Route::get('/products', Products\IndexProduct::class)->name('admin.product');
    Route::get('/products/{action}/{id?}', Products\StoreProduct::class)->name('admin.store.product');
    Route::get('/notifications', Notifications\IndexNotification::class)->name('admin.notification');
    Route::get('/notifications/{action}/{id?}', Notifications\StoreNotification::class)->name('admin.store.notification');
    Route::get('/sends', Sends\IndexSend::class)->name('admin.send');
    Route::get('/sends/{action}/{id?}', Sends\StoreSend::class)->name('admin.store.send');
    Route::get('/categories', Categories\IndexCategory::class)->name('admin.category');
    Route::get('/categories/{action}/{id?}', Categories\StoreCategory::class)->name('admin.store.category');
    Route::get('/reductions', Reductions\IndexReduction::class)->name('admin.reduction');
    Route::get('/reductions/{action}/{id?}', Reductions\StoreReduction::class)->name('admin.store.reduction');
    Route::get('/addresses', Addresses\IndexAddress::class)->name('admin.address');
    Route::get('/addresses/{action}/{id?}', Addresses\StoreAddress::class)->name('admin.store.address');
    Route::get('/articles', Articles\IndexArticle::class)->name('admin.article');
    Route::get('/articles/{action}/{id?}', Articles\StoreArticle::class)->name('admin.store.article');
    Route::get('/payments', Payments\IndexPayment::class)->name('admin.payment');
    Route::get('/payments/{action}/{id?}', Payments\StorePayment::class)->name('admin.store.payment');
    Route::get('/tasks', Tasks\IndexTask::class)->name('admin.task');
    Route::get('/tasks/{action}/{id?}', Tasks\StoreTask::class)->name('admin.store.task');
    Route::get('/users', Users\IndexUsers::class)->name('admin.user');
    Route::get('/users/{action}/{id?}', Users\StoreUsers::class)->name('admin.store.user');
    Route::get('/roles', Roles\IndexRole::class)->name('admin.role');
    Route::get('/roles/{action}/{id?}', Roles\StoreRole::class)->name('admin.store.role');
    Route::get('/settings/base', Settings\BaseSetting::class)->name('admin.setting.base');
    Route::get('/settings/home', Settings\HomeSetting::class)->name('admin.setting.home');
    Route::get('/settings/about-us', Settings\AboutSetting::class)->name('admin.setting.aboutUs');
    Route::get('/settings/contact-us', Settings\ContactSetting::class)->name('admin.setting.contactUs');
    Route::get('/settings/faq', Settings\FaqSetting::class)->name('admin.setting.faq');
    Route::get('/settings/faq/{action}/{id?}', Settings\FaqSettingStore::class)->name('admin.store.faq');
});

// user
Route::middleware('auth')->prefix('/client')->group(function () {
    Route::get('/',\App\Http\Livewire\Site\Dashboard\Dashboard\IndexDashboard::class)->name('user.dashboard');
    Route::get('/orders',\App\Http\Livewire\Site\Dashboard\Orders\IndexOrders::class)->name('user.orders');
    Route::get('/orders/{id}',\App\Http\Livewire\Site\Dashboard\Orders\SingleOrder::class)->name('user.order');
    Route::get('/returns',\App\Http\Livewire\Site\Dashboard\Returns\IndexReturn::class)->name('user.returns');
    Route::get('/returns/{action}/{id?}',\App\Http\Livewire\Site\Dashboard\Returns\StoreReturn::class)->name('user.return');
    Route::get('/notifications',\App\Http\Livewire\Site\Dashboard\Notifications\IndexNotification::class)->name('user.notifications');
    Route::get('/addresses',\App\Http\Livewire\Site\Dashboard\Addresses\IndexAddresses::class)->name('user.addresses');
    Route::get('/addresses/{action}/{id?}',\App\Http\Livewire\Site\Dashboard\Addresses\StoreAddress::class)->name('user.address');
    Route::get('/tickets',\App\Http\Livewire\Site\Dashboard\Tickets\IndexTickets::class)->name('user.tickets');
    Route::get('/tickets/{action}/{id?}',\App\Http\Livewire\Site\Dashboard\Tickets\StoreTicket::class)->name('user.ticket');
    Route::get('/profile',\App\Http\Livewire\Site\Dashboard\Profile\IndexProfile::class)->name('user.profile');
});
// auth
Route::middleware('guest')->group(function () {
    Route::get('/auth', \App\Http\Livewire\Site\Auth\Auth::class)->name('auth');
});
// logout
Route::get('/logout', function (){
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('auth');
})->name('logout');
// file manager
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth','role:admin','schedule']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});
