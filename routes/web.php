<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Ignorar todas estas rutas, son para hacer pruebas
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/index', [OfferController::class, 'index'])->name('index');
    Route::post('/createOffer', [OfferController::class, 'createOffer'])->name('createOffer');
    Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers');
    Route::get('/showCreatedOffers', [OfferController::class, 'showCreatedOffers'])->name('showCreatedOffers');

    Route::get('/index.outfit', [OutfitController::class, 'index'])->name('index.outfit');
    Route::POST('/create.outfit', [OutfitController::class, 'createOutfit'])->name('create.outfit');
    Route::get('/show.outfit', [OutfitController::class, 'showOutfits'])->name('show.outfit');

    Route::get('/prueba', [StripeController::class, 'prueba'])->name('prueba');
});

Route::POST('createUser', [AuthController::class, 'createUser'])->name('createUser');
Route::POST('loginUser', [AuthController::class, 'loginUser'])->name('loginUser');

Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers'); //Muestra todas las ofertas creadas

Route::get('/mostrarOfertas', [OfferController::class, 'mostrarOfertas'])->name('mostrarOfertas');

Route::get('/indexPago', 'App\Http\Controllers\StripeController@index')->name('indexPago');
Route::post('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
Route::get('/', 'App\Http\Controllers\StripeController@success')->name('success');