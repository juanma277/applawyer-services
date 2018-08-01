<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\Notificacion;

class NotificacionController extends Controller
{
    // =========================================
    // Obtener todas las notificaciones
    // =========================================
    public function all()
    {
        $notificaciones = DB::select('SELECT * from notificaciones');

        if(empty($notificaciones)){
            return response()->json([
                'error' => true,
                'cuenta' => count($notificaciones),
                'mensaje' => 'No existen Notificaciones'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($notificaciones),
            'notificaciones' => $notificaciones
        ]);
    }

    // ===========================================
    // Obtener todas las notificaciones activas
    // ===========================================
    public function activos()
    {
        $notificaciones = DB::select("SELECT * from notificaciones WHERE estado ='ACTIVO'");

        if(empty($notificaciones)){
            return response()->json([
                'error' => true,
                'cuenta' => count($notificaciones),
                'mensaje' => 'No existen notificaciones'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($notificaciones),
            'notificaciones' => $notificaciones
        ]);
    }

    // =========================================
    // Obtener Notificaciones Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $notificaciones = DB::select('SELECT notificaciones.id, users.nombre AS user, users.email, notificaciones.titulo, notificaciones.mensaje, notificaciones.tipo, notificaciones.estado from notificaciones JOIN users ON (users.id = notificaciones.user_id) LIMIT 10 OFFSET '.$desde);
        $cuentaNotificaciones = DB::select('SELECT * FROM notificaciones ');

        if(empty($notificaciones)){
            return response()->json([
                'error' => true,
                'cuenta' => count($notificaciones),
                'mensaje' => 'No existen notificaciones'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($notificaciones),
            'total' => count($cuentaNotificaciones),
            'notificaciones' => $notificaciones
        ]);
    }

    // =========================================
    // Buscar Notificación
    // =========================================
    public function searchNotificacion($termino)
    {   
        $notificaciones = DB::select("SELECT notificaciones.id, notificaciones.titulo, notificaciones.mensaje, notificaciones.tipo, notificaciones.estado, users.nombre AS user, users.email FROM notificaciones JOIN users ON (users.id = notificaciones.user_id) WHERE users.nombre LIKE '%".$termino."%' OR users.email LIKE '%".$termino."%' OR notificaciones.titulo LIKE '%".$termino."%' OR notificaciones.mensaje LIKE '%".$termino."%' OR notificaciones.tipo LIKE '%".$termino."%' OR notificaciones.estado LIKE '%".$termino."%'");

        if(empty($notificaciones)){
            return response()->json([
                'error' => true,
                'cuenta' => count($notificaciones),
                'mensaje' => 'No existen notificaciones'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($notificaciones),
            'notificaciones' => $notificaciones
        ]);
    }

    // =========================================
    // Crear Notificación
    // =========================================
    public function create(Request $request)
    {   
        try {
            $notificacion = DB::table('notificaciones')->insert(
                [   
                    'user_id' => $request->user, 
                    'titulo' => $request->titulo,
                    'mensaje' => $request->mensaje,
                    'tipo' => $request->tipo,
                    'estado' => $request->estado
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificación creada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Notificación
    // =========================================
    public function getNotificacion($id)
    {   
        $notificacion = Notificacion::find($id);

        if(empty($notificacion)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe notificacion'
            ]);
        }

        return response()->json([
            'error' => false,
            'notificacion' => $notificacion
        ]);
    }

    // =========================================
    // Actualizar Notificación
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE NOTIFICACION
        $notificacion = Notificacion::find($id);
        if(empty($notificacion)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe notificacion'
            ]);
        }

        try {
            $notificacion = DB::table('notificaciones')
            ->where('id', $id)
            ->update([
                        'user_id' => $request->user, 
                        'titulo' => $request->titulo,
                        'mensaje' => $request->mensaje,
                        'tipo' => $request->tipo,
                        'estado' => $request->estado
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificacion Actualizada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Eliminar Notificación
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE NOTIFICACION
        $notificacion = Notificacion::find($id);
        if(empty($notificacion)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe notificacion'
            ]);
        }

        try {
            DB::table('notificaciones')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Notificacion Eliminada'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }
}
