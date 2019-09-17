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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/beers/shoppingcart', 'BeerController@getCart')->name('beers.shoppingcart');
Route::post('/beers/saveorder', 'BeerController@saveOrder')->name('beers.saveorder');
Route::post('/beers/savedeliverynote', 'BeerController@savedeliverynote')->name('beers.savedeliverynote');
Route::get('/beers/savedeliverynote', 'BeerController@savedeliverynote')->name('beers.savedeliverynote');
Route::resource('beers', 'BeerController');
Route::get('/beers/{beer}/delete', 'BeerController@delete')
    ->name('beers.delete');
Route::get('/beers/{beer}/duplicate', 'BeerController@duplicate')
    ->name('beers.duplicate');
Route::get('/datapricing', 'BeerController@beersdatapricing')->name('beers.datapricing');
Route::get('/beers/{beer}/addtocart', 'BeerController@getAddToCart')->name('beers.addtocart');
Route::get('/beers/{beer}/fixupcart', 'BeerController@fixupCart')->name('beers.fixupshoppingcart');
Route::get('/beers/{beer}/fixdowncart', 'BeerController@fixdownCart')->name('beers.fixdownshoppingcart');

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

Route::resource('users', 'UserController');
Route::post('/roleassign', 'UserController@roleassign')
    ->name('users.roleassign');
Route::get('/users/{user}/delete', 'UserController@delete')
    ->name('users.delete');

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

Route::resource('orders', 'OrderController');
Route::resource('lines', 'LineController');

/* ----- Company ----- */

Route::resource('companies', 'CompanyController');
Route::get('/companies/{company}/delete', 'CompanyController@delete')
    ->name('companies.delete');
Route::patch('/companies/{company}/default', 'CompanyController@default')
    ->name('companies.default');

/* ----- Shipping Address ----- */

Route::resource('companies.shipping-addresses', 'ShippingAddressController', [
    'except' => ['show', 'index']
]);
Route::get('/companies/{company}/shipping-addresses/{shipping_address}/delete', 'ShippingAddressController@delete')
    ->name('companies.shipping-addresses.delete');
Route::patch('/companies/{company}/shipping-addresses/{shipping_address}/default', 'ShippingAddressController@default')
    ->name('companies.shipping-addresses.default');

/* ----- API ----- */
Route::get('/companies/{company}/shipping-address', 'CompanyController@shippingAddress')
    ->name('companies.api.shipping-address');

