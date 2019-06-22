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

Auth::routes();
Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('beers', 'BeerController');
Route::get('/beers/{beer}/delete', 'BeerController@delete')
    ->name('beers.delete');

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

Route::resource('roles', 'RoleController');
Route::get('/roles/{role}/delete', 'RoleController@delete')
    ->name('roles.delete');

Route::resource('users', 'UserController');
Route::post('/roleassign', 'UserController@roleassign')
    ->name('users.roleassign');
