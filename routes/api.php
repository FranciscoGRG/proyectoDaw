<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteClothesController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
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
    Route::PUT('/update.outfit', [OutfitController::class, 'updateOutfit'])->name('update.outfit'); //Actualiza un outfit existente
    Route::PUT('/updateLike.outfit', [OutfitController::class, 'addLike'])->name('updateLike.outfit'); //Añade un like al outfit

    //Ruta para realizar el pago
    Route::POST('/checkout', [StripeController::class, 'checkout'])->name('checkout');

    //Ruta para las prendas favoritas
    Route::get('/show.favoriteClothes', [FavoriteClothesController::class, 'showFavoriteClothes'])->name('show.favoriteClothes'); //Muestra las prendas favoritas del ususario logeado
    Route::post('/add.favoriteClothes', [FavoriteClothesController::class, 'addFavoriteClothes'])->name('add.favoriteClothes'); //Guarda la prenda seleccionada como favorita
    Route::delete('/delete.favoriteClothes', [FavoriteClothesController::class, 'deleteFavoriteClothes'])->name('delete.favoriteClothes'); //Borra la prenda favorita del usuario

    //Ruta para cambiar la imagen de perfil del usuario
    Route::PUT('/update.profile', [ProfileController::class, 'update'])->name('update.profile');
});

Route::group(['middleware' => 'cors'], function () {
    Route::post('register', [AuthController::class, 'createUser'])->name('register');
    Route::post('login', [AuthController::class, 'loginUser'])->name('login');
});

Route::get('/showOffers', [OfferController::class, 'showOffers'])->name('showOffers'); //Muestra todas las ofertas creadas a cualquier usuario
Route::get('/showAll.outfit', [OutfitController::class, 'showAllOutfits'])->name('showAll.outfit'); //Muestra todos los outfits creados para las valoraciones

Route::get('/getUser/{id}', [UserController::class, 'getUserById'])->name('getUser'); //Devuelve un usuario por ID
