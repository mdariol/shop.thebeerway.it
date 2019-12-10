<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

/* ----- Beer ----- */

Route::resource('beers', 'BeerController');
Route::get('/beers/{beer}/delete', 'BeerController@delete')
    ->name('beers.delete');
Route::get('/beers/{beer}/duplicate', 'BeerController@duplicate')
    ->name('beers.duplicate');
Route::get('/datapricing', 'BeerController@beersdatapricing')->name('beers.datapricing');
Route::get('/pricelist', 'BeerController@beerspricelist')->name('beers.pricelist');
Route::get('/pricelist/download', 'BeerController@export')->name('beers.export');

/* ----- Brewery ----- */

Route::resource('breweries', 'BreweryController');
Route::get('/breweries/{brewery}/delete', 'BreweryController@delete')
    ->name('breweries.delete');

Route::resource('packagings', 'PackagingController');
Route::get('/packagings/{packaging}/delete', 'PackagingController@delete')
    ->name('packagings.delete');

Route::resource('styles', 'StyleController');
Route::get('/styles/{style}/delete', 'StyleController@delete')
    ->name('styles.delete');

Route::resource('areas', 'AreaController');
Route::get('/areas/{area}/delete', 'AreaController@delete')
    ->name('areas.delete');

Route::resource('tastes', 'TasteController');
Route::get('/tastes/{taste}/delete', 'TasteController@delete')
    ->name('tastes.delete');

Route::resource('colors', 'ColorController');
Route::get('/colors/{color}/delete', 'ColorController@delete')
    ->name('colors.delete');

Route::resource('roles', 'RoleController');
Route::get('/roles/{role}/delete', 'RoleController@delete')
    ->name('roles.delete');

Route::resource('policies', 'PolicyController');
Route::get('/policies/{policy}/delete', 'PolicyController@delete')
    ->name('policies.delete');

Route::resource('promotions', 'PromotionController');
Route::get('/promotions/{promotion}/delete', 'PromotionController@delete')
    ->name('promotions.delete');



Route::get('/stocksync', function () {
    $exitCode = Artisan::call('fatture:sync beers --field=stock');

    if ($exitCode == 0) {
        return back()->with('success', 'Sincronizzazione completata con successo!');
    }

    return back()->withErrors($exitCode);
});

Route::resource('purchaseorders', 'PurchaseorderController');
Route::get('/purchaseorders/{purchaseorder}/delete', 'PurchaseorderController@delete')
    ->name('purchaseorders.delete');

/* ----- Auth ----- */

Route::middleware(\Spatie\Honeypot\ProtectAgainstSpam::class)->group(function () {
    Auth::routes(['verify' => true]);
});

Route::get('/login-as', 'Auth\LoginController@showLoginAsForm')->name('login-as');
Route::post('/login-as', 'Auth\LoginController@loginAs');

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/welcome', 'Auth\WelcomeController@welcome')->name('welcome');

/* ----- User ----- */

Route::resource('users', 'UserController');
Route::get('/users/{user}/delete', 'UserController@delete')
    ->name('users.delete');
Route::patch('/users/{user}/role', 'UserController@role')
    ->name('users.role');
Route::patch('/users/{user}/password', 'UserController@password')
    ->name('users.password');

/* ----- Billing Profile ----- */

Route::resource('billing-profiles', 'BillingProfileController');
Route::get('/billing-profiles/{billing_profile}/delete', 'BillingProfileController@delete')
    ->name('billing-profiles.delete');
Route::get('billing-profiles/{billing_profile}/shipping-address', 'BillingProfileController@shippingAddress')
    ->name('billing-profiles.shipping-address');
Route::patch('/billing-profiles/{billing_profile}/default', 'BillingProfileController@default')
    ->name('billing-profiles.default');
Route::patch('/billing-profiles/{billing_profile}/transition', 'BillingProfileController@transition')
    ->name('billing-profiles.transition');

/* ----- Shipping Address ----- */

Route::resource('billing-profiles.shipping-addresses', 'ShippingAddressController', [
    'except' => ['show']
]);
Route::get('/billing-profiles/{billing_profile}/shipping-addresses/{shipping_address}/delete', 'ShippingAddressController@delete')
    ->name('billing-profiles.shipping-addresses.delete');
Route::patch('/billing-profiles/{billing_profile}/shipping-addresses/{shipping_address}/default', 'ShippingAddressController@default')
    ->name('billing-profiles.shipping-addresses.default');

/* -----  Resource download----- */

Route::get('/download', 'DownloadController@download')
    ->name('download');

/* --------------------------------------------------------------------------
    Commerce
   -------------------------------------------------------------------------- */

Route::group([
    'middleware' => 'verified',
    'namespace' => 'Commerce',
], function () {

    /* ----- Order ----- */

    Route::resource('orders', 'OrderController', [
        'except' => ['edit', 'update', 'destroy'],
    ]);
    Route::patch('/orders/{order}/transition', 'OrderController@transition')
        ->name('orders.transition');

    /* ----- Line ----- */

    Route::resource('lines', 'LineController', [
        'except' => ['index', 'edit', 'create', 'store']
    ]);

    /* ----- Cart ----- */

    Route::get('/cart', 'CartController@show')
        ->name('cart.show');
    Route::post('/cart', 'CartController@add')
        ->name('cart.add');
    Route::delete('/cart', 'CartController@empty')
        ->name('cart.empty');

    /* ----- Checkout ----- */

    Route::get('/checkout', 'CheckoutController@show')
        ->name('checkout.show');
    Route::post('/checkout', 'CheckoutController@process')
        ->name('checkout.process');
});

/* --------------------------------------------------------------------------
    Admin
   -------------------------------------------------------------------------- */

Route::group([
    'prefix' => 'admin',
    'middleware' => 'admin',
    'namespace' => 'Admin',
], function () {

    /* ----- BillingProfile ----- */

    Route::get('/billing-profiles', 'BillingProfileController@index')
        ->name('admin.billing-profiles.index');

    /* ----- Order ----- */

    Route::get('/orders', 'OrderController@index')
        ->name('admin.orders.index');
    Route::get('/orders/create', 'OrderController@create')
        ->name('admin.orders.create');
    Route::post('/orders', 'OrderController@store')
        ->name('admin.orders.store');
});
