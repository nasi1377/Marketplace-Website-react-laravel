<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


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


$prefix = "App\\Http\\Controllers\\";

Route::get('/', $prefix . 'HomeController@index')->name('home');
Route::post('/', $prefix . 'NewslatterController@save')->name('save.newslatter');
//Route::get('/test/{id}/{name}', $prefix . 'GraphController@add');
//Route::get('/test/{id}/{name}/{parent_id}', $prefix . 'GraphController@addWP');
//Route::get('/weight/{id}/{level}/right', $prefix . 'GraphController@getWeight1r');
//Route::get('/weight/{id}/{level}/left', $prefix . 'GraphController@getWeight1l');
//Route::get('/weight/{id}/right', $prefix . 'GraphController@getWeight2r');
///Route::get('/weight/{id}/left', $prefix . 'GraphController@getWeight2l');
//Route::get('/makepass/{pass}', $prefix . 'GraphController@make_pass');
//Route::get('/makegraph', $prefix . 'GraphController@makegraph');
//Route::get('/makeUsers/{inviter}', $prefix . 'AuthController@makeUsers');
// Auth Routes
Route::get('/login', $prefix . 'AuthController@login')->name('login');
Route::get('/verify', $prefix . 'AuthController@verify')->name('verify');
Route::get('/forgot-password', $prefix . 'AuthController@forgotPassword')->name('forgot-password');
Route::post('/forgot-password', $prefix . 'AuthController@forgotPasswordAction')->name('forgot-password.action');
Route::post('/verify-mobile', $prefix . 'AuthController@verifyCode')->name('verify-mobile.action');


Route::get('/reset-password', $prefix . 'AuthController@resetPasswordForm')->name('reset-password-form');
Route::post('/reset-password', $prefix . 'AuthController@resetPasswordAction')->name('reset-password-action');


Route::post('/send-verify-mobile', $prefix . 'AuthController@sendVerifyCode')->name('send-verify-mobile.action');
Route::post('/login', $prefix . 'AuthController@loginAction')->name('login.action');
Route::get('/register', $prefix . 'AuthController@register')->name('register');
Route::post('/register', $prefix . 'AuthController@registerAction')->name('register.action');

Route::post('/product/{SLUG}', $prefix . 'AuthController@direct_register')->name('register.action.direct');
Route::resource('attributes', attributeController::class);

// Product Routes
Route::get('/products', $prefix . 'ProductController@products')->name('products');
Route::get('/product/{SLUG}', $prefix . 'ProductController@productDetails')->name('product.details');
Route::get('/shop-cart', $prefix . 'ProductController@shopCart')->name('add.shop.cart');
Route::get('/shop-cart/{SLUG}/remove', $prefix . 'ProductController@shopCartRemove')->name('add.shop.cart.remove');
Route::get('/shop-cart/payment', $prefix . 'ProductController@cartPayment')->name('cart.payment');
Route::get('/shop-cart/callback', $prefix . 'ProductController@callback')->name('cart.callback');
Route::post('/product/{SLUG}/add-to-card', $prefix . 'ProductController@addToCard')->name('add.product.card');
Route::post('/product/{SLUG}/save-comment', $prefix . 'ProductController@saveComment')->name('save.product.comment');
Route::post('/cart/update', $prefix . 'ProductController@update')->name('cart.update');


// Pages Routes...................
Route::get('/about-us', $prefix . 'PageController@aboutUs')->name('about-us');
Route::get('/contact-us', $prefix . 'PageController@contactUs')->name('contact-us');

Route::middleware(['auth'])->prefix('desktop')->name('desktop.')->group(function () use ($prefix) {
    Route::get('/', $prefix . 'DesktopController@index')->name('index');
    Route::get('/profile', $prefix . 'DesktopController@profile')->name('profile');
    Route::get('/invoice/{order_id}', $prefix . 'DesktopController@invoice')->name('invoice');
    Route::post('/GotoPayment/{order_id}', $prefix . 'DesktopController@GotoPayment')->name('GotoPayment');
    Route::match(['put', 'post'], '/profile', $prefix . 'DesktopController@profileUpdate')->name('profile.update');
    Route::post('/avatar_upload', $prefix . 'DesktopController@upload')->name('profile.avatar');
    Route::get('/orders', $prefix . 'DesktopController@orders')->name('orders');
    Route::post('/orders/referred', $prefix . 'DesktopController@ordersReferred')->name('orders.referred');
    Route::get('/recruitment', $prefix . 'DesktopController@recruitment')->name('recruitment');
    Route::get('/return', $prefix . 'DesktopController@return')->name('return');
    Route::put('/recruitment', $prefix . 'DesktopController@recruitmentUpdate')->name('recruitment.update');
    Route::get('/wallet', $prefix . 'DesktopController@wallet')->name('wallet');
    Route::get('/buy-major', $prefix . 'DesktopController@buyMajor')->name('buy.major');
    Route::post('/buy-major-save', $prefix . 'DesktopController@buyMajorSave')->name('buy.major.save');
    Route::post('/charge-credit', $prefix . 'DesktopController@chargeCredit')->name('charge.credit');
    Route::post('/send-request', $prefix . 'DesktopController@sendRequest')->name('send.request');

    Route::post('/send-request-rice', $prefix . 'DesktopController@sendRequestRice')->name('send.request.rice');

    Route::get('/charge-credit-callback', $prefix . 'DesktopController@CallBack')->name('wallet.callback');
    Route::post('/score-to-credit', $prefix . 'DesktopController@ScoreToCredit')->name('score.to.credit');
    Route::post('/score-to-rice', $prefix . 'DesktopController@ScoreToRice')->name('score.to.rice');
    Route::get('/relationship', $prefix . 'DesktopController@relationship')->name('relationship');
    Route::get('/gift-box', $prefix . 'DesktopController@giftBox')->name('gift.box');
    Route::get('/inactive-users', $prefix . 'DesktopController@inactiveUsers')->name('inactive.users');
    Route::get('/logout', $prefix . 'AuthController@logout')->name('logout');
    Route::post('/sendMsg', $prefix . 'DesktopController@sendMsg')->name('sendMsg');
    Route::post('/LoadMsgByUser', $prefix . 'DesktopController@LoadMsgByUser')->name('LoadMsgByUser');
    Route::post('/ReadMsgByUser', $prefix . 'DesktopController@ReadMsgByUser')->name('ReadMsgByUser');
});



Route::get('/posts', $prefix . 'BlogController@blog')->name('blog');
Route::get('/posts/{SLUG}', $prefix . 'BlogController@blogDetails')->name('blog.details');

Route::get('/books', $prefix . 'BookController@books')->name('books');
Route::get('/books/{SLUG}', $prefix . 'BookController@bookDetails')->name('book.details');


Route::get('/videos', $prefix . 'VideoController@videos')->name('videos');
Route::get('/videos/{SLUG}', $prefix . 'VideoController@videoDetails')->name('video.details');


Route::get('/checkout', $prefix . 'PageController@checkout')->name('checkout');
Route::get('/factors', $prefix . 'PageController@factors')->name('factors');



Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});



// نسترن نابغه
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('marketers', [\App\Http\Controllers\MarketerController::class, 'index'])->name('admin.marketers.index');
    Route::get('marketers/{id}', [\App\Http\Controllers\MarketerController::class, 'profile'])->name('admin.marketers.profile');

    // مسیر جدید برای نمایش هدیه ها
    Route::get('marketers/gifts/list', [\App\Http\Controllers\MarketerController::class, 'giftsList'])->name('admin.marketers.gifts');

    Route::delete('marketers/gifts/{id}', [\App\Http\Controllers\MarketerController::class, 'deleteGift'])
        ->name('admin.marketers.gifts.delete');

    Route::post('marketers/send-bulk-sms', [\App\Http\Controllers\MarketerController::class, 'sendBulkSms'])->name('admin.marketers.sendBulkSms');
    Route::post('marketers/send-gift', [\App\Http\Controllers\MarketerController::class, 'getGift'])->name('admin.marketers.sendGift');
    Route::post('marketers/send-discount', [\App\Http\Controllers\MarketerController::class, 'sendDiscount'])->name('admin.marketers.sendDiscount');
});

Route::get('/category/{slug}', [ProductController::class, 'showCategory'])->name('category.products');
