<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    //Funcion de prueba para insertar ofertas con imagenes
    public function index()
    {
        return view('Offer.index');
    }

    //Esta funcion crea una oferta en la base de datos
    public function createOffer(Request $request)
    {
        try {
            $images = $request->file('imagenes')->store('public/imagenes');
            $url = Storage::url($images);

            $Offer = [
                'name' => $request->nombre,
                'description' => $request->descripcion,
                'manufacturer' => $request->fabricante,
                'size' => $request->talla,
                'price' => $request->precio,
                'images' => $url,
                'category' => $request->categoria,
                'user_id' => Auth::user()->id,
            ];

            Offer::create($Offer);
            return response()->json(['message' => 'Oferta creada correctamente'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Esta funcion devuelve todas las ofertas
    public function showOffers()
    {
        $offers = Offer::all();
        return response()->json($offers);
    }

    //Esta funcion devuelve todas las ofertas creadas por el usuario logeado
    public function showCreatedOffers()
    {
        $offers = Offer::where('user_id', Auth::user()->id)->get();
        return response()->json($offers);
    }

    //Esta funcion actualiza una oferta dado su id y valores nuevos
    //En un input oculto en el formulario de actualizar oferta se le pasa el id de la oferta junto a los campos a actualizar
    public function updateOffer(Request $request)
    {
        try {
            // Valida los datos del formulario
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255', // 'sometimes' indica que el campo es opcional
                'description' => 'sometimes|string',
                'manufacturer' => 'sometimes|string|max:255',
                'size' => 'sometimes|string|max:50',
                'price' => 'sometimes|numeric|min:0',
                'images' => 'sometimes|array', // 'sometimes' indica que el campo es opcional
                'category' => 'sometimes|string|max:255',
            ]);

            // Busca la oferta por su ID
            $offer = Offer::find($request->id);

            // Actualiza los datos de la oferta solo si están presentes en la solicitud
            $offer->fill($validatedData)->save();

            // Redirige a alguna ruta de éxito o muestra un mensaje de éxito
            return response()->json("Oferta actualizada correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Esta funcion elimina una oferta dado su id
    public function deleteOffer(Request $request)
    {
        try {
            // Busca la oferta por su ID
            $offer = Offer::find($request->id);

            // Elimina la oferta solo si está presente en la solicitud
            $offer->delete();

            // Redirige a alguna ruta de éxito o muestra un mensaje de éxito
            return response()->json("Oferta eliminada correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al borrar la oferta: '. $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
