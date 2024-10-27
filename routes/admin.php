<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\StuffController;
use App\Http\Controllers\Admin\HelperController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\BrandTypeController;
use App\Http\Controllers\Admin\FlashDealController;
use App\Http\Controllers\Admin\SpecificationsTypes;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\SpecificationAttributes;
use App\Http\Controllers\Admin\SpecificationsController;
use App\Http\Controllers\Admin\ConfigurationSettingController;
use App\Http\Controllers\Admin\ProductStockController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/post', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['isAdmin', 'web'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');


    Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
        Route::get('add', [CategoryController::class, 'addform'])->name('add');
        Route::get('sub/add', [CategoryController::class, 'addformsub'])->name('sub.add');
        Route::any('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::any('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
        Route::any('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('sub', [CategoryController::class, 'indexsub'])->name('index.sub');
        Route::get('keys/{id}', [CategoryController::class, 'categoryKeys'])->name('keys');

        Route::group(['prefix' => 'specification', 'as' => 'specification.'], function () {
            Route::get('keys', [SpecificationsController::class, 'index'])->name('key.index');
            Route::get('keys/public', [SpecificationsController::class, 'publickeys'])->name('key.public');
            Route::get('key/create', [SpecificationsController::class, 'create'])->name('key.create');
            Route::post('key/store', [SpecificationsController::class, 'store'])->name('key.store');
            Route::patch('key/update/{id}', [SpecificationsController::class, 'update'])->name('key.update');
            Route::get('key/show/{id}', [SpecificationsController::class, 'show'])->name('key.show');
            Route::post('status/{id}', [SpecificationsController::class, 'updatestatus'])->name('key.status');
            Route::post('public/{id}', [SpecificationsController::class, 'updateIsPublic'])->name('key.is_public');
            Route::post('updateposition/{id}', [SpecificationsController::class, 'updateposition'])->name('key.position');
            Route::any('delete/{id}', [SpecificationsController::class, 'delete'])->name('key.delete');
            Route::get('types/{id}', [SpecificationsController::class, 'keyTypes'])->name('types');
            
            // don't remove from here, otherwise it will create 302 redirection somehow
            Route::get('type-create', [SpecificationsTypes::class, 'create'])->name('type.create');

            Route::group(['prefix' => 'types', 'as' => 'type.'], function () {
                Route::get('/', [SpecificationsTypes::class, 'index'])->name('index');
            
            
                Route::post('store', [SpecificationsTypes::class, 'store'])->name('store');
                Route::patch('update/{id}', [SpecificationsTypes::class, 'update'])->name('update');
                Route::get('show/{id}', [SpecificationsTypes::class, 'show'])->name('show');
                Route::post('status/{id}', [SpecificationsTypes::class, 'updatestatus'])->name('status');
                Route::post('show_on_filter/{id}', [SpecificationsTypes::class, 'filterstatus'])->name('filter');
                Route::post('updateposition/{id}', [SpecificationsTypes::class, 'updateposition'])->name('position&filter');
                Route::any('delete/{id}', [SpecificationsTypes::class, 'delete'])->name('delete');
                Route::get('attributes/{id}', [SpecificationsTypes::class, 'typeAttributes'])->name('attributes');

                Route::group(['prefix' => 'attributes', 'as' => 'attribute.'], function () {
                    Route::get('/', [SpecificationAttributes::class, 'index'])->name('index');
                    Route::get('create', [SpecificationAttributes::class, 'create'])->name('create');
                    Route::post('store', [SpecificationAttributes::class, 'store'])->name('store');
                    Route::patch('update/{id}', [SpecificationAttributes::class, 'updateAttributes'])->name('update');
                    Route::get('show/{id}', [SpecificationAttributes::class, 'show'])->name('show');
                    Route::post('update/{id}', [SpecificationAttributes::class, 'update'])->name('update');
                    Route::post('status/{id}', [SpecificationAttributes::class, 'updatestatus'])->name('status');
                    Route::any('delete/{id}', [SpecificationAttributes::class, 'delete'])->name('delete');
                });
            });
        });
    });
    Route::post('category/is/featured/{id}', [CategoryController::class, 'updateisFeatured'])->name('category.is_featured');
    Route::post('category/status/{id}', [CategoryController::class, 'updatestatus'])->name('category.status');
    Route::any('/slug-check', [HelperController::class, 'checkSlug'])->name('slug.check');

    // flash-deal
    Route::resource('flash-deal', FlashDealController::class);

    // stock
    Route::post('stock/status/{id}', [ProductStockController::class, 'updateStatus'])->name('stock.status');
    Route::resource('stock', ProductStockController::class);

    // Product
    Route::post('product/duplicate/{id}', [ProductController::class, 'duplicate'])->name('product.duplicate');
    Route::get('product/stock/{id}', [ProductController::class, 'stock'])->name('product.stock');
    Route::post('product/status/{id}', [ProductController::class, 'updateStatus'])->name('product.status');
    Route::post('product/featured/{id}', [ProductController::class, 'updateFeatured'])->name('product.featured');
    Route::resource('product', ProductController::class);
    Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::any('store', [ProductController::class, 'store'])->name('store');
        Route::group(['prefix' => 'specifications', 'as' => 'specification.'], function () {
            Route::get('/', [ProductController::class, 'specification'])->name('index');
            Route::post('add/{productId}', [ProductController::class, 'specificationsAdd'])->name('add');
            Route::get('edit', [ProductController::class, 'specificationproducts'])->name('edit');
            Route::get('edit/{id}', [ProductController::class, 'specificationproductModal'])->name('edit.modal');
            Route::get('edit/page/{id}', [ProductController::class, 'specificationProductPage'])->name('edit.page');
            Route::post('keyfeature/{id}', [ProductController::class, 'keyfeature'])->name('keyfeature');
            Route::any('delete/{id}', [ProductController::class, 'delete'])->name('delete');
        });
    });

    // Import
    Route::get('import/category', [ImportController::class, 'category'])->name('import.category');
    Route::post('import/category/post', [ImportController::class, 'importCategories'])->name('upload.category');
    Route::get('import/brand', [ImportController::class, 'brand'])->name('import.brand');
    Route::post('import/brand/post', [ImportController::class, 'importBrands'])->name('upload.brand');
    Route::get('import/product', [ImportController::class, 'product'])->name('import.product');
    Route::post('import/product/post', [ImportController::class, 'importProducts'])->name('upload.product');

    Route::get('/image-upload', [ImageController::class, 'index'])->name('image.index');
    Route::post('/image-upload', [ImageController::class, 'upload'])->name('image.upload');
    Route::delete('/image-delete/{filename}', [ImageController::class, 'delete'])->name('image.delete');

    // Order
    Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('details/{id}', [OrderController::class, 'details'])->name('details');
        Route::post('/{orderId}/update-status', [OrderController::class, 'updateStatus'])->name('update.status');
        Route::get('invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
       
    });

    // Question
    Route::get('customer/question', [QuestionController::class, 'index'])->name('customer.question.index');
    Route::get('customer/question/answer/{id}', [QuestionController::class, 'answer'])->name('customer.question.answer');
    Route::patch('customer/question/submit-answer', [QuestionController::class, 'submitAnswer'])->name('customer.question.update');

    // Customer
    Route::post('customer/status/{id}', [CustomerController::class, 'updateStatus'])->name('customer.status');
    Route::resource('customer', CustomerController::class);

    // Brand Types
    Route::post('brand-type/status/{id}', [BrandTypeController::class, 'updateStatus'])->name('brand_type.status');
    Route::post('brand-type/feature/{id}', [BrandTypeController::class, 'updateFeatured'])->name('brand_type.featured');
    Route::resource('brand-type', BrandTypeController::class);

    // Brand
    Route::post('brand/status/{id}', [BrandController::class, 'updateStatus'])->name('brand.status');
    Route::post('brand/featured/{id}', [BrandController::class, 'updateFeatured'])->name('brand.featured');
    Route::resource('brand', BrandController::class);

    // Banner
    Route::post('banner/status/{id}', [BannerController::class, 'updateStatus'])->name('banner.status');
    Route::resource('banner', BannerController::class);

    // Coupon
    Route::post('coupon/status/{id}', [CouponController::class, 'updateStatus'])->name('coupon.status');
    Route::resource('coupon', CouponController::class);

    // City
    Route::post('get-city-information-by-id', [CityController::class, 'getCityInformationById'])->name('get-city-information-by-id');
    Route::post('city/status/{id}', [CityController::class, 'updateStatus'])->name('city.status');
    Route::resource('city', CityController::class);

    // Country
    Route::post('get-country-information-by-id', [CountryController::class, 'getCountryInformationById'])->name('get-country-information-by-id');
    Route::post('country/status/{id}', [CountryController::class, 'updateStatus'])->name('country.status');
    Route::resource('country', CountryController::class);

    // Zone
    Route::post('get-zone-information-by-id', [ZoneController::class, 'getZoneInformationById'])->name('get-zone-information-by-id');
    Route::post('zone/status/{id}', [ZoneController::class, 'updateStatus'])->name('zone.status');
    Route::resource('zone', ZoneController::class);

    // Stuff
    Route::resource('stuff', StuffController::class);

    // Roles Route
    Route::resource('roles', RoleController::class);

    // Currency
    Route::post('zone/currency/{id}', [CurrencyController::class, 'updateStatus'])->name('currency.status');
    Route::resource('currency', CurrencyController::class);

    // Tax
    Route::post('tax/status/{id}', [TaxController::class, 'updateStatus'])->name('tax.status');
    Route::resource('tax', TaxController::class);

    Route::post('page/status/{id}', [PageController::class, 'updateStatus'])->name('page.status');
    Route::resource('page', PageController::class);

    // Settings
    Route::view('homepage/configuration', 'backend.settings.homepageSettings')->name('homepage.settings');
    Route::post('homepage/settings/{section}', [HomePageController::class, 'visibility'])->name('homepage.settings.status');
    Route::post('cache/clear', [HelperController::class, 'cacheClear'])->name('clear.cache');
    Route::controller(ConfigurationSettingController::class)->group(function () {
        Route::get('settings/general', 'general')->name('settings.general');
        Route::get('settings/otp', 'otp')->name('settings.otp');
        Route::get('settings/vat', 'vat')->name('settings.vat');

        Route::get('website/header', 'websiteHeader')->name('website.header');
        Route::get('website/footer', 'websiteFooter')->name('website.footer');
        Route::get('website/appearance', 'websiteAppearance')->name('website.appearance');

        Route::post('settings/update', 'update')->name('settings.update');
    });

    // System
    Route::view('/server-status', 'backend.system.server_status')->name('system_server');
    Route::get('banner/source/{source}', [SearchController::class, 'getSourceOptions'])->name('banner.source');
});

// Add this to your web.php for testing purposes
Route::get('/livewire-components', function () {
    return response()->json(\Livewire\Livewire::getComponentNames());
});
