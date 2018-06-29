<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Process;

class ProcessesController extends Controller
{
    // =========================================
    // Obtener todos los procesos
    // =========================================
    public function all()
    {
        $process = DB::select('SELECT * from proceso');

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($process),
            'process' => $process
        ]);
    }

    // =========================================
    // Obtener todos los procesos de un usuario
    // =========================================
    public function allUsuer($id)
    {
        $process = DB::select("SELECT proceso.id,proceso.demandante,proceso.demandado,proceso.radicado,proceso.fecha,juzgado.nombre AS juzgado,tipo_proceso.nombre AS tipo,
        (SELECT CONCAT(historial_proceso.actuacion,'*',historial_proceso.anotacion,'*',historial_proceso.fecha) FROM historial_proceso WHERE historial_proceso.proceso_id = proceso.id order by historial_proceso.fecha DESC LIMIT 1) as historico,
        (SELECT COUNT(1) FROM historial_proceso WHERE historial_proceso.proceso_id = proceso.id) AS actuaciones FROM proceso  JOIN juzgado ON (proceso.juzgado_id = juzgado.id) JOIN tipo_proceso ON (proceso.tipo_proceso_id = tipo_proceso.id) WHERE proceso.user_id =".$id);

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($process),
            'process' => $process
        ]);
    }

    // =========================================
    // Obtener los procesos Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $process = DB::select('SELECT * from proceso LIMIT 10 OFFSET '.$desde);

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen Procesos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($process),
            'process' => $process
        ]);
    }

    // =========================================
    // Crear Proceso
    // =========================================
    public function create(Request $request)
    {   
        try {
            $city = DB::table('proceso')->insert(
                [   'tipo_proceso_id' => $request->tipo_proceso,
                    'user_id' => $request->user, 
                    'juzgado_id' => $request->juzgado, 
                    'demandante' => $request->demandante, 
                    'demandado' => $request->demandado,
                    'radicado' => $request->radicado, 
                    'fecha' => $request->fecha
                    ]
                );

            return response()->json([
                'error' => false,
                'mensaje' => 'Proceso creado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Proceso con historial
    // =========================================
    public function getProcesses($id)
    {   
        $datosProceso = DB::select("SELECT proceso.radicado, proceso.demandante, proceso.demandado, proceso.fecha, juzgado.nombre AS juzgado, ciudad.nombre as ciudad, tipo_proceso.nombre AS tipo FROM proceso JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE proceso.id =".$id);
        $process = DB::select("SELECT proceso.radicado, juzgado.nombre AS juzgado, tipo_proceso.nombre AS tipo, proceso.demandante, proceso.demandado, proceso.fecha, historial_proceso.actuacion, historial_proceso.anotacion, historial_proceso.fecha FROM proceso JOIN historial_proceso ON (historial_proceso.proceso_id = proceso.id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.juzgado_id) WHERE proceso.id =".$id ." ORDER BY historial_proceso.fecha DESC");

        if(empty($process)){
            return response()->json([
                'error' => true,
                'mensaje' => 'El proceso no tiene historial',
                'data' => $datosProceso
            ]);
        }

        return response()->json([
            'error' => false,
            'process' => $process,
            'data' => $datosProceso
        ]);
    }

    // =========================================
    // Actualizar Proceso
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE PROCESO
        $process = Process::find($id);
        if(empty($process)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Proceso'
            ]);
        }

        try {
            $city = DB::table('proceso')
            ->where('id', $id)
            ->update([  'tipo_proceso_id' => $request->tipo_proceso,
                        'user_id' => $request->user, 
                        'juzgado_id' => $request->juzgado, 
                        'demandante' => $request->demandante, 
                        'demandado' => $request->demandado,
                        'radicado' => $request->radicado, 
                        'fecha' => $request->fecha
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Proceso Actualizado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Proceso
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL PROCESO
        $process = Process::find($id);
        if(empty($process)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe proceso'
            ]);
        }

        try {
            DB::table('proceso')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Proceso Eliminado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
