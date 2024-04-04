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

    //Esta funcion crea un outfit
    public function createOutfit(Request $request)
    {
        try {
            $urls = []; // Array para almacenar las URLs de las imágenes

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $image) {
                    $path = $image->store('public/imagenes');
                    $url = Storage::url($path);
                    $urls[] = $url; // Añade la URL de la imagen al array
                }
            }

            // Convertir el array de URLs a JSON para almacenarla en la base de datos
            $imagesJson = json_encode($urls);

            // Valida los datos del formulario
            $validatedData = $request->validate([
                'tipo' => 'required|string',
                'zapatos' => 'required|string',
                'pantalones' => 'required|string',
                'camiseta' => 'required|string',
                'abrigo' => 'string',
                'complementos' => 'string',
            ]);

            //Creo el outfit
            $Outfit = [
                'type' => $validatedData['tipo'],
                'footwear' => $validatedData['zapatos'],
                'trousers' => $validatedData['pantalones'],
                'Tshirt' => $validatedData['camiseta'],
                'coat' => $validatedData['abrigo'],
                'complements' => $validatedData['complementos'],
                'images' => $imagesJson,
                'user_id' => Auth::user()->id,
            ];

            FavoriteOutfit::create($Outfit);
            return response()->json(['message' => 'Outfit creada correctamente'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el outfit: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Esta funcion devuelve los outfits favoritos del usuario logeado
    public function showOutfits()
    {
        $outfits = FavoriteOutfit::where('user_id', Auth::user()->id)->get();
        return response()->json($outfits);
        // return view('Outfit\mostrarOutfit', ['outfits' => $outfits]);
    }

    public function deleteOutfit(Request $request)
    {
        try {
            // Busca la oferta por su ID
            $outfit = FavoriteOutfit::find($request->id);

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
            // Valida los datos del formulario
            $validatedData = $request->validate([
                'type' => 'sometimes|string|max:255', // 'sometimes' indica que el campo es opcional
                'footwear' => 'sometimes|string|max:255',
                'trousers' => 'sometimes|string|max:255',
                'Tshirt' => 'sometimes|string|max:255',
                'coat' => 'sometimes|string|max:255',
                'complements' => 'sometimes|string|max:255',
                'images' => 'sometimes|string|max:255',
            ]);

            // Busca el outfit por su ID
            $outfit = FavoriteOutfit::find($request->id);

            // Actualiza los datos del outfit solo si están presentes en la solicitud
            $outfit->fill($validatedData)->save();

            return response()->json("Outfit actualizado correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
