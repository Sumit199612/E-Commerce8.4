<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/admin', 'AdminController@login');

Route::get('/logout', 'AdminController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Index Page
Route::get('/', 'IndexController@index');

// Category/Listing Page
Route::get('/products/{url}', 'ProductsController@products');

// Product Detail Page
Route::get('/product/{id}', 'ProductsController@product');

//Get Product Attribute Price
Route::get('/get-product-price', 'ProductsController@getProductPrice');

// Apply Coupon
Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');

// Add to Cart Route
Route::match(['get', 'post'], '/add-cart', 'ProductsController@addtocart');

// Cart Page
Route::match(['get', 'post'], '/cart', 'ProductsController@cart');

// Delete Cart Products
Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');

// Update Cart Products Quantity
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');

// User Login/Register/ page
Route::get('/login-register', 'UsersController@userLoginRegister');

//User Register Form Submit
Route::post('/user-register', 'UsersController@register');

//Confirm Account
Route::get('confirm/{code}', 'UsersController@confirmAccount');

//User Login Form Submit
Route::post('/user-login', 'UsersController@login');

// User Logout
Route::get('/user-logout', 'UsersController@logout');
//Check if User already exists
Route::match(['GET', 'POST'], '/check-email', 'UsersController@checkEmail');

// All Routes after Login
Route::group(['middleware' => ['frontlogin']], function () {
    // User Account Page
    Route::match(['GET', 'POST'], 'account', 'UsersController@account');
    // Check Users's Current Password
    Route::post('/check-user-pwd', 'UsersController@chkUserPassword');
    // Update User Password
    Route::post('/update-user-pwd', 'UsersController@updatePassword');
    // Checkout Page
    Route::match(['GET', 'POST'], 'checkout', 'ProductsController@checkout');
    // Order Review
    Route::match(['GET', 'POST'], '/order-review', 'ProductsController@orderReview');
    // Place Order
    Route::match(['GET', 'POST'], '/place-order', 'ProductsController@placeOrder');
    //Thanks Page for COD mode of payments.
    Route::get('/thanks', 'ProductsController@thanks');
    //Thanks Page for paytm mode of payments.
    Route::get('/paytm', 'ProductsController@paytm');
    //Thanks Page for paypal mode of payments.
    Route::get('/paypal', 'ProductsController@paypal');
    //Users order page
    Route::get('/orders', 'ProductsController@userOrders');
    //User ordered product page
    Route::get('/orders/{id}', 'ProductsController@userOrderDetails');

    //PayTM Routes
    Route::get('/initiate', 'PaytmController@initiate')->name('initiate.payment');
    Route::post('/payment', 'PaytmController@pay')->name('make.payment');
    Route::post('/payment/status', 'PaytmController@paymentCallback')->name('status');
});

Route::group(['middleware' => ['adminlogin']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/settings', 'AdminController@settings');
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

    //Category Routes For Admin

    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');

    //Product Routes For Admin

    Route::match(['get', 'post'], '/admin/add-product', 'ProductsController@addProduct');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    Route::get('/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    Route::get('/admin/view-products', 'ProductsController@viewProducts');

    //Products Attributes Route For Admin
    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductsController@addAttributes');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}', 'ProductsController@editAttributes');
    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductsController@addImages');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

    // Coupon Routes
    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon');
    Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons');

    // Routes To View Users Order on Admin Pannel
    Route::get('/admin/view-orders', 'ProductsController@viewOrders');

    // Routes To View Users Order Details on Admin Pannel
    Route::get('/admin/view-orders/{id}', 'ProductsController@viewOrderDetails');

    // Update Order Status
    Route::post('/admin/update-order-status', 'ProductsController@updateOrderStatus');

    // Admin Banners Routes
    Route::match(['get', 'post'], '/admin/add-banner', 'BannersController@addBanner');
    Route::match(['get', 'post'], '/admin/edit-banner/{id}', 'BannersController@editBanner');
    Route::get('/admin/delete-banner/{id}', 'BannersController@deleteBanner');
    Route::get('/admin/delete-banner-image/{id}', 'BannersController@deleteBannerImage');
    Route::get('/admin/view-banners', 'BannersController@viewBanners');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
