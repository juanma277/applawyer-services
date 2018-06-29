<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Alarma;

class AlarmaController extends Controller
{
    // =========================================
    // Obtener todas las Alarmas
    // =========================================
    public function all()
    {
        $alarmas = DB::select('SELECT * from alarmas');

        if(empty($alarmas)){
            return response()->json([
                'error' => true,
                'cuenta' => count($alarmas),
                'mensaje' => 'No existen alarmas'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($alarmas),
            'alarmas' => $alarmas
        ]);
    }

    // =========================================
    // Obtener todas las alarmas de un Proceso
    // =========================================
    public function allAlarmas($id)
    {
        $alarmas = DB::select("SELECT * FROM alarmas WHERE proceso_id = ".$id);

        if(empty($alarmas)){
            return response()->json([
                'error' => true,
                'cuenta' => count($alarmas),
                'mensaje' => 'No existen alarmas'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($alarmas),
            'alarmas' => $alarmas
        ]);
    }

    // =========================================
    // Obtener Alarma por ID
    // =========================================
    public function getAlarma($id)
    {
        $alarma = Alarma::find($id);

        if(empty($alarma)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe alarma'
            ]);
        }

        return response()->json([
            'error' => false,
            'alarma' => $alarma
        ]);
    }

    // =========================================
    // Obtener las alarmas Paginadas
    // =========================================
    public function paginate($desde=0)
    {   
        $alarmas = DB::select('SELECT * from alarmas LIMIT 10 OFFSET '.$desde);

        if(empty($alarmas)){
            return response()->json([
                'error' => true,
                'cuenta' => count($alarmas),
                'mensaje' => 'No existen alarmas'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($alarmas),
            'process' => $alarmas
        ]);
    }

    // =========================================
    // Crear Alarma
    // =========================================
    public function create(Request $request)
    {   
        try {
            $alarma = Alarma::create(
                    [   
                        'proceso_id' => $request->proceso_id,
                        'descripcion' => $request->descripcion, 
                        'fecha' => $request->fecha, 
                        'hora' => $request->hora 
                    ]
                );

            return response()->json([
                'error' => false,
                'mensaje' => 'Alarma creada',
                'alarma' => $alarma
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Actualizar Alarma
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE ALARMA
        $alarma = Alarma::find($id);
        if(empty($alarma)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Alarma'
            ]);
        }

        try {
            $alarma = DB::table('alarmas')
            ->where('id', $id)
            ->update([  
                        'descripcion' => $request->descripcion, 
                        'fecha' => $request->fecha, 
                        'hora' => $request->hora 
                    ]);
            
            $alarmas = DB::select("SELECT * from alarmas WHERE proceso_id =".$request->proceso_id);

            return response()->json([
                'error' => false,
                'mensaje' => 'Alarma Actualizada',
                'alarmas' => $alarmas
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Alarma
    // =========================================
    public function delete($alarma_id, $proceso_id)
    {  
        //VERIFICAR QUE EXISTE LA ALARMA
        $alarma = Alarma::find($alarma_id);
        
        if(empty($alarma)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Alarma'
            ]);
        }

        try {
            DB::table('alarmas')->where('id', '=', $alarma_id)->delete();

            $alarmas = DB::select("SELECT * from alarmas WHERE proceso_id =".$proceso_id);

            return response()->json([
                'error' => false,
                'mensaje' => 'Alarma Eliminada',
                'alarmas' => $alarmas
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
