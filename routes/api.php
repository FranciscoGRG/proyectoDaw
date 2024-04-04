<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OutfitController;
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

    //Grupo de rutas de ofertas
    Route::post('/createOffer', [OfferController::class, 'createOffer'])->name('createOffer'); //Crea la oferta en la base de datos
    Route::put('/updateOffer', [OfferController::class, 'updateOffer'])->name('updateOffer'); //Actualiza la oferta en la base de datos
    Route::delete('/deleteOffer', [OfferController::class, 'deleteOffer'])->name('deleteOffer'); //Elimina la oferta en la base de datos
    Route::get('/showCreatedOffers', [OfferController::class, 'showCreatedOffers'])->name('showCreatedOffers'); //Muestra las ofertas creadas por el usuario logeado
    Route::get('/user', function () {
        return auth()->user();
    });

    //Grupo de rutas de outfits
    Route::POST('/create.outfit', [OutfitController::class, 'createOutfit'])->name('create.outfit'); //Crea un outfit favorito
    Route::get('/show.outfit', [OutfitController::class, 'showOutfits'])->name('show.outfit'); //Devuelve los outfit del usuario
    Route::delete('/delete.outfit', [OutfitController::class, 'deleteOutfit'])->name('delete.outfit'); //Elimina un outfit
    Route::put('/update.outfit', [OfferController::class, 'updateOutfit'])->name('update.outfit'); //Actualiza el outfit en la base de datos
});

Route::POST('register', [AuthController::class, 'createUser'])->name('register'); //Registra un nuevo usuario
Route::POST('login', [AuthController::class, 'loginUser'])->name('login'); //Logea un usuario

Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers'); //Muestra todas las ofertas creadas a cualquier usuario
