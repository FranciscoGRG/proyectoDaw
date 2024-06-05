<?php

namespace App\Http\Controllers;

use App\Models\FavoriteOutfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class OutfitController extends Controller
{
    //Funcion de prueba para probar a insertar outfits con imágenes
    public function index()
    {
        return view('outfit.index');
    }

    public function index2()
    {
        return view('outfit.update');
    }

    //Esta funcion crea un outfit
    public function createOutfit(Request $request)
    {

        $camiseta = $request->camiseta;
        $pantalon = $request->pantalon;
        $zapatos = $request->zapatos;


        // return response()->json($zapatos['zapatos_imagen']);

        try {

            $outfit = new FavoriteOutfit();
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
            $outfit->user_id = Auth::id();



            $outfit->save();

            return response()->json(['message' => 'Outfit creado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el outfit favorito: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Esta funcion devuelve los outfits favoritos del usuario logeado
    public function showOutfits()
    {
        $userId = Auth::id();

        // Obtener todos los outfits del usuario actual
        $outfits = FavoriteOutfit::where('user_id', $userId)->get();

        // Devolver los outfits en formato JSON
        return response()->json($outfits);
    }

    public function deleteOutfit(Request $request)
    {
        try {
            // Busca la oferta por su ID
            $outfit = FavoriteOutfit::find($request->outfit_id);

            // ELimina la oferta
            $outfit->delete();

            return response()->json("Outfit eliminado correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al borrar el outfit: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateOutfit(Request $request)
    {
        try {
            // Obtener los datos del outfit actualizados del cuerpo de la solicitud HTTP

            // Buscar el outfit actual del usuario
            $outfit = FavoriteOutfit::where('id', $request->outfit_id)->first();

            // Verificar si el outfit existe
            if ($outfit) {
                // Verificar si la camiseta está cambiando
                if ($request->camiseta['camiseta_nombre'] && $request->camiseta['camiseta_precio'] && $request->camiseta['camiseta_imagen'] && $request->camiseta['camiseta_url']) {
                    $outfit->camiseta = [
                        'nombre' => $request->camiseta['camiseta_nombre'],
                        'precio' => $request->camiseta['camiseta_precio'],
                        'imagen' => $request->camiseta['camiseta_imagen'],
                        'url' => $request->camiseta['camiseta_url'],
                    ];
                }

                if ($request->pantalon['pantalon_nombre'] && $request->pantalon['pantalon_precio'] && $request->pantalon['pantalon_imagen'] && $request->pantalon['pantalon_url']) {
                    $outfit->pantalon = [
                        'nombre' => $request->pantalon['pantalon_nombre'],
                        'precio' => $request->pantalon['pantalon_precio'],
                        'imagen' => $request->pantalon['pantalon_imagen'],
                        'url' => $request->pantalon['pantalon_url'],
                    ];
                }

                if ($request->zapatos['zapatos_nombre'] && $request->zapatos['zapatos_precio'] && $request->zapatos['zapatos_imagen'] && $request->zapatos['zapatos_url']) {
                    $outfit->zapatos = [
                        'nombre' => $request->zapatos['zapatos_nombre'],
                        'precio' => $request->zapatos['zapatos_precio'],
                        'imagen' => $request->zapatos['zapatos_imagen'],
                        'url' => $request->zapatos['zapatos_url'],
                    ];
                }

                // Guardar los cambios en el outfit
                $outfit->save();

                return response()->json(['message' => 'Outfit actualizado correctamente.'], 200);
            } else {
                return response()->json(['message' => 'No se encontró un outfit para actualizar.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el outfit: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function showAllOutfits()
    {
        $outfits = FavoriteOutfit::all();
        return response()->json($outfits);
    }

    public function addLike(Request $request)
    {
        $outfit = FavoriteOutfit::find($request->outfit_id);
        $outfit->likes = $outfit->likes + 1;
        $outfit->save();
        return response()->json($outfit);
    }
}
