<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use DB;
use App\Adjunto;

class AdjuntoController extends Controller
{
    // =========================================
    // Obtener todos los Adjuntos
    // =========================================
    public function all()
    {
        $adjuntos = DB::select('SELECT * from adjuntos');

        if(empty($adjuntos)){
            return response()->json([
                'error' => true,
                'cuenta' => count($adjuntos),
                'mensaje' => 'No existen adjuntos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($adjuntos),
            'adjuntos' => $adjuntos
        ]);
    }

    // =========================================
    // Obtener todos los Adjuntos de un proceso
    // =========================================
    public function allAdjuntos($id)
    {
        $adjuntos = DB::select("SELECT * FROM adjuntos WHERE proceso_id = ".$id);

        if(empty($adjuntos)){
            return response()->json([
                'error' => true,
                'cuenta' => count($adjuntos),
                'mensaje' => 'No existen adjuntos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($adjuntos),
            'adjuntos' => $adjuntos
        ]);
    }

    // =========================================
    // Obtener Adjunto por ID
    // =========================================
    public function getAdjunto($id)
    {
        $adjunto = Alarma::find($id);

        if(empty($adjunto)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe adjunto'
            ]);
        }

        return response()->json([
            'error' => false,
            'adjunto' => $adjunto
        ]);
    }

    // =========================================
    // Obtener los Adjuntos Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $adjuntos = DB::select('SELECT * from adjuntos LIMIT 10 OFFSET '.$desde);

        if(empty($adjuntos)){
            return response()->json([
                'error' => true,
                'cuenta' => count($adjuntos),
                'mensaje' => 'No existen adjuntos'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($adjuntos),
            'adjuntos' => $adjuntos
        ]);
    }

    // =========================================
    // Crear Adjunto
    // =========================================
    public function create(Request $request)
    {   
        $imagen = explode(',', $request->archivo );
        $data = base64_decode($imagen[1]);
        $archivo = $request->proceso_id+"-"+rand()+".png";
        $filepath = "/public/storage/"+$archivo;

        file_put_contents($filepath, $data);

        try {
            $adjunto = Adjunto::create(
                    [   
                        'proceso_id' => $request->proceso_id,
                        'descripcion' => $request->descripcion, 
                        'archivo' => $request->archivo 
                    ]
                );

            return response()->json([
                'error' => false,
                'mensaje' => 'Adjunto creado',
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
    // Actualizar Adjunto
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
    // Eliminar Adjunto
    // =========================================
    public function delete($adjunto_id, $proceso_id)
    {  
        //VERIFICAR QUE EXISTE EL ADJUNTO
        $adjunto = Adjunto::find($adjunto_id);
        
        if(empty($adjunto)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe Adjunto'
            ]);
        }

        try {
            DB::table('adjuntos')->where('id', '=', $adjunto_id)->delete();

            $adjuntos = DB::select("SELECT * from adjuntos WHERE proceso_id =".$proceso_id);

            return response()->json([
                'error' => false,
                'mensaje' => 'Adjunto Eliminado',
                'adjuntos' => $adjuntos
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
