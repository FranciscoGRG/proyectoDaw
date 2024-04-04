<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class OfferController extends Controller
{
    //Función de prueba para probar a insertar ofertas con imágenes
    public function index()
    {
        return view('Offer.index');
    }

    //Función de prueba para mostrar las ofertas con varias imágenes
    public function mostrarOfertas()
    {
        $ofertas = Offer::all();
        return view('Offer.mostrarOfertas', ['offers' => $ofertas]);
    }

    //Esta función crea una oferta en la base de datos
    public function createOffer(Request $request)
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
                'nombre' => 'required|string',
                'descripcion' => 'required|string',
                'fabricante' => 'required|string',
                'talla' => 'required|string',
                'precio' => 'required|numeric|min:0',
                'imagenes' => 'required|array',
                'categoria' => 'required|string',
            ]);

            //Creo la oferta
            $Offer = [
                'name' => $validatedData['nombre'],
                'description' => $validatedData['descripcion'],
                'manufacturer' => $validatedData['fabricante'],
                'size' => $validatedData['talla'],
                'price' => $validatedData['precio'],
                'images' => $imagesJson, // Almacena todas las URLs de las imágenes como JSON
                'category' => $validatedData['categoria'],
                'user_id' => Auth::user()->id,
            ];

            Offer::create($Offer);
            return response()->json(['message' => 'Oferta creada correctamente'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    //Esta función devuelve todas las ofertas
    public function showOffers()
    {
        $offers = Offer::all();
        return response()->json($offers);
    }

    //Esta función devuelve todas las ofertas creadas por el usuario logeado
    public function showCreatedOffers()
    {
        $offers = Offer::where('user_id', Auth::user()->id)->get();
        return response()->json($offers);
    }

    //Esta función actualiza una oferta dado su id y valores nuevos
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
                'images' => 'sometimes|array', 
                'category' => 'sometimes|string|max:255',
            ]);

            // Busca la oferta por su ID
            $offer = Offer::find($request->id);

            // Actualiza los datos de la oferta solo si están presentes en la solicitud
            $offer->fill($validatedData)->save();

            return response()->json("Oferta actualizada correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //Esta función elimina una oferta dado su id
    public function deleteOffer(Request $request)
    {
        try {
            // Busca la oferta por su ID
            $offer = Offer::find($request->id);

            // ELimina la oferta
            $offer->delete();

            return response()->json("Oferta eliminada correctamente", Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al borrar la oferta: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
