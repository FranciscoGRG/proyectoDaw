<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     Route::get('/index', [OfferController::class, 'index'])->name('index'); //Muestra formulario de creacion de oferta
//     Route::post('/createOffer', [OfferController::class, 'createOffer'])->name('createOffer'); //Crea la oferta en la base de datos
//     Route::get('/showCreatedOffers', [OfferController::class, 'showCreatedOffers'])->name('showCreatedOffers'); //Muestra las ofertas creadas por el usuario logeado
// });

Route::middleware('auth')->group(function () {
    Route::get('/index', [OfferController::class, 'index'])->name('index');
    Route::post('/createOffer', [OfferController::class, 'createOffer'])->name('createOffer');
    Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers');
    Route::get('/showCreatedOffers', [OfferController::class, 'showCreatedOffers'])->name('showCreatedOffers');
});

Route::POST('createUser', [AuthController::class, 'createUser'])->name('createUser');
Route::POST('loginUser', [AuthController::class, 'loginUser'])->name('loginUser');

Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers'); //Muestra todas las ofertas creadas

