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
    public function allUser($id, $desde)
    {
        $process = DB::select("SELECT proceso.id, proceso.demandante, proceso.demandado, proceso.radicado, proceso.fecha, juzgado.nombre AS juzgado,tipo_proceso.nombre AS tipo,
        (SELECT CONCAT(historial_proceso.actuacion,'*',historial_proceso.anotacion,'*',historial_proceso.fecha) FROM historial_proceso WHERE historial_proceso.proceso_id = proceso.id order by historial_proceso.fecha DESC LIMIT 1) as historico,
        (SELECT COUNT(1) FROM historial_proceso WHERE historial_proceso.proceso_id = proceso.id) AS actuaciones FROM proceso  JOIN juzgado ON (proceso.juzgado_id = juzgado.id) JOIN tipo_proceso ON (proceso.tipo_proceso_id = tipo_proceso.id) WHERE proceso.user_id =".$id." LIMIT 10 OFFSET ".$desde);

        $cuenta = DB::select("SELECT id FROM proceso WHERE proceso.user_id =".$id);

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen procesos'
            ]);
        }

        $procesoEstado = DB::select("SELECT COUNT(1) AS cantidad, proceso.estado FROM proceso WHERE proceso.user_id =".$id." GROUP BY proceso.estado");

        return response()->json([
            'error' => false,
            'cuenta' => count($cuenta),
            'process' => $process,
            'estados' => $procesoEstado
        ]);
    }

    // =========================================
    // Obtener los procesos Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $process = DB::select('SELECT proceso.id, tipo_proceso.id AS tipo, users.nombre AS user, juzgado.id AS juzgado, juzgado.ciudad_id AS ciudad, proceso.demandante, proceso.demandado, proceso.radicado, proceso.fecha, proceso.estado FROM proceso JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN users ON (users.id = proceso.user_id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) LIMIT 10 OFFSET '.$desde);
        $cuentaProcess = DB::select('SELECT * from proceso');

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
            'total' => count($cuentaProcess),
            'process' => $process
        ]);
    }

    // ===============================================
    // Obtener los procesos de un Usuario por Juzgado
    // ===============================================
    public function porJuzgado($id)
    {   
        $process = DB::select("SELECT COUNT(1) as cantidad, juzgado.nombre, juzgado.abreviatura AS ABV  FROM `proceso` JOIN juzgado ON (juzgado.id = proceso.juzgado_id) WHERE user_id =".$id." GROUP BY juzgado.nombre");

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

    // ===============================================
    // Obtener los procesos de un Usuario por Tipo
    // ===============================================
    public function porTipo($id)
    {   
        $process = DB::select("SELECT COUNT(1) as cantidad, tipo_proceso.nombre, tipo_proceso.abreviatura AS ABV  FROM `proceso` JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) WHERE user_id =".$id." GROUP BY tipo_proceso.nombre");

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

    // ===============================================
    // Obtener los procesos de un Usuario por Ciudad
    // ===============================================
    public function porCiudad($id)
    {   
        $process = DB::select("SELECT COUNT(1) as cantidad, ciudad.nombre FROM `proceso` JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE proceso.user_id=".$id." GROUP BY ciudad.nombre");

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


    // ===============================================
    // Obtener los procesos de un Usuario por Estado
    // ===============================================
    public function porEstado($id)
    {   
        $process = DB::select("SELECT COUNT(1) as cantidad, proceso.estado FROM `proceso` WHERE proceso.user_id=".$id." GROUP BY proceso.estado");

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
    // Buscar Proceso
    // =========================================
    public function searchProccess($termino)
    {   
        $process = DB::select("SELECT proceso.id, ciudad.id AS ciudad, tipo_proceso.id AS tipo, juzgado.id AS juzgado, users.nombre AS user, proceso.demandante, proceso.demandado, proceso.radicado, proceso.fecha, proceso.estado FROM proceso JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN users ON (users.id = proceso.user_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE ciudad.nombre LIKE '%".$termino."%' OR tipo_proceso.nombre LIKE '%".$termino."%' OR juzgado.nombre LIKE '%".$termino."%' OR users.nombre LIKE '%".$termino."%' OR proceso.demandante LIKE '%".$termino."%' OR proceso.demandado LIKE '%".$termino."%' OR proceso.radicado LIKE '%".$termino."%' OR proceso.fecha LIKE '%".$termino."%' OR proceso.estado LIKE '%".$termino."%'");

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
            'procesos' => $process
        ]);
    }


    // =========================================
    // Crear Proceso
    // =========================================
    public function create(Request $request)
    {   
        try {
            $process = DB::table('proceso')->insert(
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
    // Buscar Proceso
    // =========================================
    public function searchProcesos($termino, $id)
    {   
        $process = DB::select("SELECT proceso.id, radicado, demandante, demandado, fecha, juzgado.nombre AS juzgado, tipo_proceso.nombre AS tipo, (SELECT CONCAT(historial_proceso.actuacion,'*',historial_proceso.anotacion,'*',historial_proceso.fecha) FROM historial_proceso WHERE historial_proceso.proceso_id = proceso.id order by historial_proceso.fecha DESC LIMIT 1) as historico FROM proceso JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) WHERE (radicado LIKE '%".$termino."%' OR demandante LIKE '%".$termino."%' OR tipo_proceso.nombre LIKE '%".$termino."%' OR juzgado.nombre LIKE '%".$termino."%' OR demandado LIKE '%".$termino."%') AND proceso.user_id = ".$id);

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
            'procesos' => $process
        ]);
    }

    // =========================================
    // Obtener Proceso con historial
    // =========================================
    public function getProcesses($id)
    {   
        $datosProceso = DB::select("SELECT proceso.radicado, proceso.demandante, proceso.demandado, proceso.fecha, proceso.estado, juzgado.nombre AS juzgado, ciudad.nombre as ciudad, tipo_proceso.nombre AS tipo FROM proceso JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE proceso.id =".$id);
        $historial = DB::select("SELECT * FROM `historial_proceso` WHERE historial_proceso.proceso_id =".$id." ORDER BY historial_proceso.fecha DESC");

        if(empty($historial)){
            return response()->json([
                'error' => true,
                'mensaje' => 'El proceso no tiene historial',
                'data' => $datosProceso
            ]);
        }

        return response()->json([
            'error' => false,
            'process' => $historial,
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
            $process = DB::table('proceso')
            ->where('id', $id)
            ->update([  
                        'tipo_proceso_id' => $request->tipo_proceso,
                        'juzgado_id' => $request->juzgado, 
                        'demandante' => $request->demandante, 
                        'demandado' => $request->demandado,
                        'radicado' => $request->radicado, 
                        'fecha' => $request->fecha,
                        'estado'=>$request->estado
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
    // Actualizar Estado de Proceso
    // =========================================
    public function updateStatus(Request $request, $id)
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
            $process = DB::table('proceso')
            ->where('id', $id)
            ->update([
                       'estado' => $request->estado,
                    ]);
            
            $process = Process::find($id);              

            return response()->json([
                'error' => false,
                'mensaje' => 'Proceso Actualizado',
                'data' => $process
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
    public function delete($id, $user_id)
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
            DB::table('proceso')->where('id', '=', $id)->delete();

            $process = DB::select("SELECT * from proceso WHERE user_id =".$user_id);

            return response()->json([
                'error' => false,
                'mensaje' => 'Proceso Eliminado',
                'procesos' => $process
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }

    // =========================================
    // Eliminar Proceso - desde Admin
    // =========================================
    public function deleteAdmin($id)
    {  
        //VERIFICAR QUE EXISTE EL PROCESO
        $process = Process::find($id);
        if(empty($process)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe el Proceso',
                'id' => 'id : '+$id
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
