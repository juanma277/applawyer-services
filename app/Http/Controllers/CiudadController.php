<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\City;

class CiudadController extends Controller
{
    // =========================================
    // Obtener todas las ciudades
    // =========================================
    public function all()
    {
        $cities = DB::select('SELECT * from ciudad');

        if(empty($cities)){
            return response()->json([
                'error' => true,
                'cuenta' => count($cities),
                'mensaje' => 'No existen ciudades'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($cities),
            'cities' => $cities
        ]);
    }

    // =========================================
    // Obtener las ciudades Paginadas
    // =========================================
    public function paginate($desde=0)
    {   
        $cities = DB::select('SELECT * from ciudad LIMIT 10 OFFSET '.$desde);

        if(empty($cities)){
            return response()->json([
                'error' => true,
                'cuenta' => count($cities),
                'mensaje' => 'No existen Ciudades'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($cities),
            'cities' => $cities
        ]);
    }

    // ===========================================
    // Obtener todas las ciudades Activos
    // ===========================================
    public function activos()
    {
        $cities = DB::select("SELECT ciudad.* FROM ciudad WHERE ciudad.estado = 'ACTIVO'");

        if(empty($cities)){
            return response()->json([
                'error' => true,
                'cuenta' => count($cities),
                'mensaje' => 'No existen Ciudades'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($cities),
            'cities' => $cities
        ]);
    }

    // =========================================
    // Crear ciudad
    // =========================================
    public function create(Request $request)
    {   
        try {
            $city = DB::table('ciudad')->insert(
                [   'nombre' => $request->nombre, 
                    ]
                );

            return response()->json([
                'error' => false,
                'mensaje' => 'Ciudad creada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener ciudad
    // =========================================
    public function getCities($id)
    {   
        $city = City::find($id);

        if(empty($city)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe ciudad'
            ]);
        }

        return response()->json([
            'error' => false,
            'city' => $city
        ]);
    }

    // =========================================
    // Actualizar ciudad
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE CIUDAD
        $city = City::find($id);
        if(empty($city)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe ciudad'
            ]);
        }

        try {
            $city = DB::table('ciudad')
            ->where('id', $id)
            ->update(['nombre' => $request->nombre, 
                      'estado' => $request->estado,
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Ciudad Actualizada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar ciudad
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $city = City::find($id);
        if(empty($city)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe ciudad'
            ]);
        }

        try {
            DB::table('ciudad')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Ciudad Eliminada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
