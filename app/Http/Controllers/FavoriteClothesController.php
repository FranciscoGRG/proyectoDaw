<?php

namespace App\Http\Controllers;

use App\Models\Favorite_clothe;
use App\Models\FavoriteOutfit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FavoriteClothesController extends Controller
{
    public function showFavoriteClothes()
    {
        $user = Auth::user();
        $favoriteClothes = $user->favorite_clothes;
        return response()->json($favoriteClothes);
    }


    public function addFavoriteClothes(Request $request)
    {
        // // Validar los datos de la solicitud
        // $validatedData = $request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'precio' => 'required|numeric',
        //     'imagen' => 'required|url',
        //     'URL' => 'required|url',
        // ]);

        // // Crear una nueva instancia de FavoriteClothes
        // $favoriteClothes = new Favorite_clothe();
        // $favoriteClothes->nombre = $validatedData['nombre'];
        // $favoriteClothes->precio = $validatedData['precio'];
        // $favoriteClothes->imagen = $validatedData['imagen'];
        // $favoriteClothes->URL = $validatedData['URL'];

        // // Guardar la prenda favorita en la base de datos
        // $favoriteClothes->save();

        // // Obtener el usuario autenticado
        // $user = Auth::user();

        // // Asociar la prenda favorita con el usuario
        // $user->favorite_clothes()->attach($favoriteClothes->id);

        // return response()->json(['message' => 'Prenda favorita añadida correctamente.'], 200);

        $camiseta = $request->camiseta;
        $pantalon = $request->pantalon;
        $zapatos = $request->zapatos;

        // return response()->json($request);

        try {
            $outfit = new Favorite_clothe();
            $outfit->camiseta = [
                'nombre' => $camiseta['camiseta_nombre'],
                'precio' => $camiseta['camiseta_precio'],
                'imagen' => $camiseta['camiseta_imagen'],
                'url' => $camiseta['camiseta_url'],
            ];
            $outfit->pantalon = [
                'nombre' => $pantalon['pantalon_nombre'],
                'precio' => $pantalon['pantalon_precio'],
                'imagen' => $pantalon['pantalon_imagen'],
                'url' => $pantalon['pantalon_url'],
            ];
            $outfit->zapatos = [
                'nombre' => $zapatos['zapatos_nombre'],
                'precio' => $zapatos['zapatos_precio'],
                'imagen' => $zapatos['zapatos_imagen'],
                'url' => $zapatos['zapatos_url'],
            ];
            $outfit->creador = $request->user_id;
            $outfit->outfit_id = $request->outfit_id;
            // return response()->json($camiseta);
            $outfit->save();

            $user = Auth::user();

            $user->favorite_clothes()->attach($outfit->id);

            return response()->json(['message' => 'Outfit añadido a fav correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el outfit favorito: ' . $e->getMessage()], 500);
        }
    }

    public function indexFavoriteClothes()
    {
        return view('añadirRopaFav');
    }

    public function deleteFavoriteClothes(Request $request)
    {
        try {
            // Obtener el usuario autenticado
            $user = Auth::user();

            $outfitfav = FavoriteOutfit::find($request->outfit_id);
            $outfitfav->likes = $outfitfav->likes - 1;
            $outfitfav->save();

            // Busca la prenda favorita por su ID
            $favoriteClothes = Favorite_clothe::find($request->id);

            // Comprueba si la prenda favorita existe
            if (!$favoriteClothes) {
                return response()->json(['message' => 'Prenda favorita no encontrada.'], Response::HTTP_NOT_FOUND);
            }

            // Verifica si está asociada con el usuario logeado
            if (!$user->favorite_clothes()->where('favorite_clothe_id', $favoriteClothes->id)->exists()) {
                return response()->json(['message' => 'Prenda favorita no está asociada con el usuario.'], Response::HTTP_FORBIDDEN);
            }

            // Elimina la asociación entre el usuario y la prenda favorita
            $user->favorite_clothes()->detach($favoriteClothes->id);

            // Elimina la prenda favorita solo si no está asociada con otros usuarios
            if ($favoriteClothes->users()->count() == 0) {
                $favoriteClothes->delete();
            }

            return response()->json(['message' => 'Prenda favorita eliminada correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la prenda favorita: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
