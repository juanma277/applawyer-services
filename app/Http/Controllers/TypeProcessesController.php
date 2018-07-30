<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Type;

class TypeProcessesController extends Controller
{
    // =========================================
    // Obtener todos los Tipos de Procesos
    // =========================================
    public function all()
    {
        $types = DB::select('SELECT * from tipo_proceso');

        if(empty($types)){
            return response()->json([
                'error' => true,
                'cuenta' => count($types),
                'mensaje' => 'No existen tipos de procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($types),
            'types' => $types
        ]);
    }

    // ===========================================
    // Obtener todos los Tipos de Procesos Activos
    // ===========================================
    public function activos()
    {
        $types = DB::select("SELECT * from tipo_proceso WHERE estado ='ACTIVO'");

        if(empty($types)){
            return response()->json([
                'error' => true,
                'cuenta' => count($types),
                'mensaje' => 'No existen tipos de procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($types),
            'types' => $types
        ]);
    }

    // =========================================
    // Obtener los Tipos de Procesos Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $types = DB::select('SELECT * from tipo_proceso LIMIT 10 OFFSET '.$desde);
        $cuentaTypes = DB::select('SELECT * FROM tipo_proceso ');

        if(empty($types)){
            return response()->json([
                'error' => true,
                'cuenta' => count($types),
                'mensaje' => 'No existen tipos de procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($types),
            'total' => count($cuentaTypes),
            'types' => $types
        ]);
    }

    // =========================================
    // Buscar Tipo
    // =========================================
    public function searchType($termino)
    {   
        $types = DB::select("SELECT id, nombre, abreviatura, estado FROM tipo_proceso WHERE nombre LIKE '%".$termino."%' OR abreviatura LIKE '%".$termino."%' OR estado LIKE '%".$termino."%'");

        if(empty($types)){
            return response()->json([
                'error' => true,
                'cuenta' => count($types),
                'mensaje' => 'No existen Tipos de Proceso'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($types),
            'types' => $types
        ]);
    }

    // =========================================
    // Crear Tipo de Proceso
    // =========================================
    public function create(Request $request)
    {   
        try {
            $type = DB::table('tipo_proceso')->insert(
                [   
                    'nombre' => $request->nombre, 
                    'abreviatura' => $request->abreviatura,
                    'estado' => $request->estado                 
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Tipo de proceso creado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Tipo de Proceso
    // =========================================
    public function getProcesses($id)
    {   
        $type = Type::find($id);

        if(empty($type)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe tipo de proceso'
            ]);
        }

        return response()->json([
            'error' => false,
            'type' => $type
        ]);
    }

    // =========================================
    // Actualizar Tipo de Proceso
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE TIPO DE PROCESO
        $type = Type::find($id);
        if(empty($type)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe tipo de proceso'
            ]);
        }

        try {
            $type = DB::table('tipo_proceso')
            ->where('id', $id)
            ->update([
                        'nombre' => $request->nombre, 
                        'abreviatura' => $request->abreviatura,
                        'estado' => $request->estado,
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Tipo de proceso Actualizado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Tipo de Proceso
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $type = Type::find($id);
        if(empty($type)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe tipo de proceso'
            ]);
        }

        try {
            DB::table('tipo_proceso')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Tipo de proceso Eliminado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
