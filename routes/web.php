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

Auth::routes();

//tutte le rotte dell'admin (/admin) saranno gestite da blade e laravel
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('posts', 'PostController');
    Route::resource('categories', 'CategoryController');
    
    //per far si che laravel e blade continuino a gestire le rotte /admin/{any}     
    Route::get('/{any}', function(){
        // e mostrare la page 404
        abort('404');
    })->where('any', '.*' );
});
//tutte le altre saranno gestite da vue, per cui 'lascio il controllo della rotta'
Route::get('/{any?}', function () {
    return view('guest.home');
});