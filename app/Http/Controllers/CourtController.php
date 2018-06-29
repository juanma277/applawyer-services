<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Court;

class CourtController extends Controller
{
    // =========================================
    // Obtener todos los Juzgados
    // =========================================
    public function all()
    {
        $courts = DB::select('SELECT * from juzgado');

        if(empty($courts)){
            return response()->json([
                'error' => true,
                'cuenta' => count($courts),
                'mensaje' => 'No existen juzgados'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($courts),
            'courts' => $courts
        ]);
    }

    // ===========================================
    // Obtener todos los Juzgados Activos
    // ===========================================
    public function activos()
    {
        $courts = DB::select("SELECT juzgado.*, ciudad.nombre AS ciudad FROM juzgado JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE juzgado.estado = 'ACTIVO'");

        if(empty($courts)){
            return response()->json([
                'error' => true,
                'cuenta' => count($courts),
                'mensaje' => 'No existen Juzgados'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($courts),
            'courts' => $courts
        ]);
    }

    // =========================================
    // Obtener los juzgados Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $courts = DB::select('SELECT * from juzgado LIMIT 10 OFFSET '.$desde);

        if(empty($courts)){
            return response()->json([
                'error' => true,
                'cuenta' => count($courts),
                'mensaje' => 'No existen Juzgados'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($courts),
            'courts' => $courts
        ]);
    }

    // =========================================
    // Crear Juzgado
    // =========================================
    public function create(Request $request)
    {   
        try {
            $court = DB::table('juzgado')->insert(
                [   'nombre' => $request->nombre,
                    'ciudad_id' => $request->ciudad
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Juzgado creado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Juzgado
    // =========================================
    public function getCourt($id)
    {   
        $court = Court::find($id);

        if(empty($court)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Juzgado'
            ]);
        }

        return response()->json([
            'error' => false,
            'court' => $court
        ]);
    }

    // =========================================
    // Actualizar Juzgado
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE JUZGADO
        $court = Court::find($id);
        if(empty($court)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Juzgado'
            ]);
        }

        try {
            $court = DB::table('juzgado')
            ->where('id', $id)
            ->update([   'nombre' => $request->nombre,
                         'ciudad_id' => $request->ciudad
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Juzgado Actualizado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Juzgado
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL JUZGADO
        $court = Court::find($id);
        if(empty($court)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Juzgado'
            ]);
        }

        try {
            DB::table('juzgado')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Juzgado Eliminado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
