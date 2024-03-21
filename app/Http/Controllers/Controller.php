<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use App\Models\minion;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function insertarEmpleado (Request $request) {
        $empleadO = [
            'nombre' => $request['nombre'],
            'posicion' => $request['posicion'],
            'salario' => $request['salario'],
        ];


        empleado::create($empleadO);
        return response()->json("Empleado creado");
    }

    public function borrarEmpleado (Request $request){

        empleado::destroy($request->id);
        return response()->json("Empleado borrado");
    }

    public function obtenerEmpleados () {
        $empleados = empleado::All();
        return response()->json($empleados);
    }

    public function actualizarEmpleado (Request $request) {


        $empleado = empleado::find($request->id);

        foreach ($request->input() as $atributo => $valorAtributo) {
            if ($empleado->offsetExists($atributo)) {
                $empleado->$atributo = $valorAtributo;
            }
        }

        $empleado->save();

        return response()->json("Datos actualizados");
    }

    public function insertarMinion (Request $request) {
        $minion = [
            'nombre' => $request['nombre'],
            'user_id' => auth()->id(),
        ];

       


        minion::create($minion);
        return response()->json("Minion creado");
    }

    

    
}
