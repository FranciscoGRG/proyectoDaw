<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/createOffer', [OfferController::class, 'createOffer'])->name('createOffer'); //Crea la oferta en la base de datos
    Route::put('/updateOffer', [OfferController::class, 'updateOffer'])->name('updateOffer'); //Actualiza la oferta en la base de datos
    Route::delete('/deleteOffer', [OfferController::class, 'deleteOffer'])->name('deleteOffer'); //Elimina la oferta en la base de datos

    Route::get('/showCreatedOffers', [OfferController::class, 'showCreatedOffers'])->name('showCreatedOffers'); //Muestra las ofertas creadas por el usuario logeado
    Route::get('/user', function () {
        return auth()->user();
    });
});

Route::POST('register', [AuthController::class, 'createUser'])->name('register'); //Registra un nuevo usuario
Route::POST('login', [AuthController::class, 'loginUser'])->name('login'); //Logea un usuario

Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers'); //Muestra todas las ofertas creadas a cualquier usuario
