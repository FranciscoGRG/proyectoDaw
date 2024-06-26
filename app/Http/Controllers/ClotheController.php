<?php

namespace App\Http\Controllers;

use App\Models\create_clothes_table;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClotheController extends Controller
{
    //Añadir color secundario
    public function getOutfit(Request $request)
    {
        try {
            // Obtener los parámetros del request
            $colores = [$request->input('colorPrincipal'), $request->input('colorSecundario')];
            $genero = $request->input('genero');
            $longitud = $request->input('longitud');
            $tipoVestimenta = $request->input('tipoVestimenta');

            // Filtrar las prendas por los parámetros recibidos
            $camiseta = create_clothes_table::where('genero', $genero)
                ->where('tipo', $tipoVestimenta)
                // ->where('largo', $longitud)
                ->whereIn('color', $colores)
                ->where(function ($query) {
                    $query->where('nombre', 'Camisa')
                        ->orWhere('nombre', 'Camiseta')
                        ->orWhere('nombre', 'Vestido');
                })
                ->get();

            $pantalon = create_clothes_table::where('nombre', 'Pantalon')
                ->where('genero', $genero == 'Mujer' ? 'Hombre' : $genero) // Para Mujer, pantalon debe ser de Hombre
                ->where('tipo', $tipoVestimenta)
                // ->where('largo', $longitud)
                ->whereIn('color', $colores)
                ->get();

            $zapatos = create_clothes_table::where('nombre', 'Zapatos')
                ->where('genero', $genero)
                ->where('tipo', $tipoVestimenta)
                ->whereIn('color', $colores)
                ->get();

            // Verificar si se encontraron resultados para cada categoría
            // if ($camiseta->isEmpty() || $pantalon->isEmpty() || $zapatos->isEmpty()) {
            //     return response()->json(['message' => 'No se han encontrado prendas que coincidan'], Response::HTTP_NOT_FOUND);
            // }

            $resultado = [
                'camiseta' => $camiseta,
                'pantalon' => $pantalon,
                'zapatos' => $zapatos,
            ];

            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al buscar prendas: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
