<?php

namespace App\Http\Controllers;

use App\Models\Favorite_clothe;
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


    //Conprobar si funciona
    public function addFavoriteClothes(Request $request)
    {
        // Validar los datos de la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'required|url',
            'URL' => 'required|url',
        ]);

        // Crear una nueva instancia de FavoriteClothes
        $favoriteClothes = new Favorite_clothe();
        $favoriteClothes->nombre = $validatedData['nombre'];
        $favoriteClothes->precio = $validatedData['precio'];
        $favoriteClothes->imagen = $validatedData['imagen'];
        $favoriteClothes->URL = $validatedData['URL'];

        // Guardar la prenda favorita en la base de datos
        $favoriteClothes->save();

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Asociar la prenda favorita con el usuario
        $user->favorite_clothes()->attach($favoriteClothes->id);

        return response()->json(['message' => 'Prenda favorita añadida correctamente.'], 200);
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
