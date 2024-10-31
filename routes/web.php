<?php

use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\PhoneBookController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\LaptopFinderController;

// Route::get('/', function () {
//     return view('frontend.homepage.index');
// })->name('home');

Route::get('laptop-buying-guide', [LaptopFinderController::class, 'index'])->name('laptop-buying-guide');
Route::get('laptop-offer', [LaptopFinderController::class, 'index'])->name('laptop.offer');
Route::get('pc-builder', [LoginController::class, 'pcBuilder'])->name('pc-builder');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('forget-password', [LoginController::class, 'forgotPassword'])->name('forget-password');
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('login/post', [LoginController::class, 'login'])->name('login.post');
Route::post('register/post', [RegisterController::class, 'register'])->name('register.post');

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

Route::middleware(['isCustomer', 'web','ipSession'])->group(function () {
    Route::get('account', function() {
        return redirect()->route('dashboard');
    });
    Route::get('dashboard', function() {
        return redirect()->route('dashboard');
    });
    
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('account/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::prefix('account')->name('account.')->group(function () {
        Route::resource('phone-book', PhoneBookController::class);
        Route::resource('address-book', AddressController::class);
        Route::get('my-orders', [UserController::class, 'myOrders'])->name('my_orders');
        Route::get('quotes', [UserController::class, 'quotes'])->name('quote');
        Route::get('edit-profile', [UserController::class, 'profile'])->name('edit_profile');
        Route::post('update-profile', [UserController::class, 'updateProfile'])->name('update.profile');
        Route::get('change-password', [UserController::class, 'password'])->name('change_password');
        Route::post('update-password', [UserController::class, 'updatePassword'])->name('update.password');
        Route::get('wish-list', [UserController::class, 'wishlist'])->name('wishlist');
        Route::delete('wish-list/destroy/{id}', [UserController::class, 'destroyWishlist'])->name('wishlist.destroy');
        Route::get('saved-pc', [UserController::class, 'saved_pc'])->name('saved_pc');
        Route::get('star-points', [UserController::class, 'star_points'])->name('star_points');
        Route::get('transaction', [UserController::class, 'transactions'])->name('transaction');
    });
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('checkout',[OrderController::class,'checkout'])->name('checkout');
        Route::any('place',[OrderController::class,'store'])->name('store');
        Route::post('get_address/{id}',[OrderController::class,'address'])->name('address');
    });
});

Route::middleware(['web','ipSession'])->group(function () {
    Route::any('/',[HomePageController::class,'index'])->name('home');

    Route::get('compare', [HomePageController::class, 'compare'])->name('compare');
    Route::get('compare/remove/{slug}', [HomePageController::class, 'removeCompare'])->name('compare.remove');

    Route::post('ajax-search', [SearchController::class, 'ajaxSearch'])->name('ajax-search');
    Route::get('ajax-product-search', [SearchController::class, 'ajaxSearchProduct'])->name('ajax.product.search');

    Route::get('on-sale-products', [HomePageController::class, 'onSaleProduct'])->name('on-sale-product');
    Route::get('featured-products', [HomePageController::class, 'onSaleProduct'])->name('featured-product');
    Route::get('top-rated-products', [HomePageController::class, 'onSaleProduct'])->name('top-rated-product');

    Route::post('newsletter-form-submit', [HomePageController::class, 'postNewsletter'])->name('post.newsletter');
    
    Route::post('add-to-compare-list', [HomePageController::class, 'addToCompareList'])->name('add-to-compare-list');
    Route::post('coupon/check', [HomePageController::class, 'couponCheck'])->name('coupon.check');
    Route::post('add-to-wish-list', [HomePageController::class, 'addToWishList'])->name('add-to-wish-list');
    Route::post('submit-question-form', [HomePageController::class,'submitQuestionForm'])->name('question-form.submit');
    Route::post('submit-review-form', [HomePageController::class,'submitReviewForm'])->name('review.submit');
    Route::any('quick-view/{slug}',[HomePageController::class,'quickview'])->name('quick.view');
    Route::get('brands', [HomePageController::class, 'allBrands'])->name('brands');
    Route::get('categories', [HomePageController::class, 'allCategories'])->name('categories');
    
    Route::post('search/category', [SearchController::class, 'searchByCategory'])->name('search.category');
    Route::post('search/category-by-id', [SearchController::class, 'searchByCategoryId'])->name('search.category_by_id');
    Route::post('search/brand-by-id', [SearchController::class, 'searchByBrandId'])->name('search.brand_by_id');
    Route::post('search/brands', [SearchController::class, 'searchByBrands'])->name('search.brands');
    Route::post('search/product', [SearchController::class, 'searchByProduct'])->name('search.product');
    Route::post('search/product-by-id', [SearchController::class, 'searchByProductId'])->name('search.product_id');
    Route::post('search/product-stock', [SearchController::class, 'searchForProductStock'])->name('search.product_stock');
    Route::post('search/product-data', [SearchController::class, 'searchForProductDetails'])->name('search.product_data');
    Route::post('search/brand-types', [SearchController::class, 'searchForBrandTypes'])->name('search.brand-types');
    
    Route::get('/get-countries', [AddressController::class, 'getCountriesByZone'])->name('getCountries');
    Route::get('/get-cities', [AddressController::class, 'getCitiesByCountry'])->name('getCities');
    Route::post('/currency/change', [HomePageController::class, 'currencyChange'])->name('currency.change');

    Route::post('/get-cart-items', [HomePageController::class, 'getCartItems'])->name('get-cart-items');
    Route::delete('/remove-cart-items', [HomePageController::class, 'removeCartItems'])->name('remove-cart-items');
    Route::post('/cart/add', [HomePageController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/sub', [HomePageController::class, 'subToCart'])->name('cart.sub');
    
    Route::post('filter/products', [HelperController::class, 'filterProduct'])->name('filter.products');

    Route::get('cart', [HomePageController::class, 'cart'])->name('cart');
    Route::post('add-quantity-to-cart', [HomePageController::class, 'addQtyToCart'])->name('add.cart');

    Route::get('search', [HelperController::class, 'search'])->name('search');
    Route::any('{slug}', [HelperController::class, 'fetcher'])->name('slug.handle');
});