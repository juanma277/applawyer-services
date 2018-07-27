<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Process;
use DB;

class pdfController extends Controller
{
    public function procesosPDF($id){

        $process = DB::select("SELECT proceso.demandante, proceso.demandado, proceso.radicado, proceso.fecha, proceso.estado, tipo_proceso.nombre AS tipo, juzgado.nombre AS juzgado from proceso  JOIN tipo_proceso ON(tipo_proceso.id = proceso.tipo_proceso_id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) WHERE user_id=".$id);
        $usuario = DB::select("SELECT nombre, email FROM users WHERE id=".$id);

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen procesos'
            ]);
        }

        $pdf = \PDF::loadView('pdf.procesos', ['process' => $process, 'usuario' => $usuario]);
        return $pdf->download('procesos.pdf');
    }


    public function actuacionPDF($id){

        $datosProceso = DB::select("SELECT proceso.radicado, proceso.demandante, proceso.demandado, proceso.fecha, proceso.estado, juzgado.nombre AS juzgado, ciudad.nombre as ciudad, tipo_proceso.nombre AS tipo FROM proceso JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE proceso.id =".$id);
        $process = DB::select("SELECT proceso.radicado, juzgado.nombre AS juzgado, tipo_proceso.nombre AS tipo, proceso.demandante, proceso.demandado, proceso.fecha, historial_proceso.actuacion, historial_proceso.anotacion, historial_proceso.fecha FROM proceso JOIN historial_proceso ON (historial_proceso.proceso_id = proceso.id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.juzgado_id) WHERE proceso.id =".$id ." ORDER BY historial_proceso.fecha DESC");

        if(empty($process)){
            return response()->json([
                'error' => true,
                'mensaje' => 'El proceso no tiene historial',
                'data' => $datosProceso
            ]);
        }

        $pdf = \PDF::loadView('pdf.actuacion', ['process' => $process, 'datosProceso' => $datosProceso]);
        return $pdf->download('actuacion.pdf');
    }

    public function usuariosPDF(){

        $users = DB::select("SELECT * FROM users");

        if(empty($users)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existen usuarios',
            ]);
        }

        $pdf = \PDF::loadView('pdf.usuarios', ['users' => $users]);
        return $pdf->download('usuarios.pdf');
    }


    public function tiposPDF(){

        $types = DB::select("SELECT * FROM tipo_proceso");

        if(empty($types)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existen tipos de procesos',
            ]);
        }

        $pdf = \PDF::loadView('pdf.tipos', ['types' => $types]);
        return $pdf->download('tipos.pdf');
    }

    public function procesosXLS($id){

        $nombre = '';
        $email = '';

        \Excel::create('Mis Procesos', function($excel) use ($id){
            $excel->sheet('Procesos', function($sheet) use ($id){
                
                $process = DB::select("SELECT proceso.radicado, proceso.demandante, proceso.demandado, tipo_proceso.nombre AS tipo, juzgado.nombre AS juzgado, proceso.fecha, proceso.estado from proceso  JOIN tipo_proceso ON(tipo_proceso.id = proceso.tipo_proceso_id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) WHERE user_id=".$id);
                $usuario = DB::select("SELECT nombre, email FROM users WHERE id=".$id);
                //DATA
                $data= json_decode( json_encode($process), true);
                $sheet->fromArray($data);             
            });
        })->export('xls');
    }


    public function actuacionXLS($id){

        \Excel::create('Actuaciones', function($excel) use ($id){
            $excel->sheet('Actuaciones', function($sheet) use ($id){
                
                $datosProceso = DB::select("SELECT proceso.radicado, proceso.demandante, proceso.demandado, proceso.fecha, proceso.estado, juzgado.nombre AS juzgado, ciudad.nombre as ciudad, tipo_proceso.nombre AS tipo FROM proceso JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.tipo_proceso_id) JOIN ciudad ON (ciudad.id = juzgado.ciudad_id) WHERE proceso.id =".$id);
                $process = DB::select("SELECT proceso.radicado, juzgado.nombre AS juzgado, tipo_proceso.nombre AS tipo, proceso.demandante, proceso.demandado, proceso.fecha, historial_proceso.actuacion, historial_proceso.anotacion, historial_proceso.fecha FROM proceso JOIN historial_proceso ON (historial_proceso.proceso_id = proceso.id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) JOIN tipo_proceso ON (tipo_proceso.id = proceso.juzgado_id) WHERE proceso.id =".$id ." ORDER BY historial_proceso.fecha DESC");
                //DATA
                $data= json_decode( json_encode($process), true);
                $data2= json_decode( json_encode($datosProceso), true);

                $sheet->fromArray($data, $data2);             
            });
        })->export('xls');
    }

    public function usuariosXLS(){

        \Excel::create('Usuarios', function($excel){
            $excel->sheet('Usuarios', function($sheet){
                
                $users = DB::select("SELECT id, nombre, email, direccion, telefono, descripcion, profesion, role, estado, created_at, updated_at FROM users" );
                //DATA
                $data= json_decode( json_encode($users), true);
                $sheet->fromArray($data);             
            });
        })->export('xls');
    }

    public function tiposXLS(){

        \Excel::create('Tipos', function($excel){
            $excel->sheet('Tipos', function($sheet){
                
                $types = DB::select("SELECT id, nombre, abreviatura, estado, created_at, updated_at FROM tipo_proceso" );
                //DATA
                $data= json_decode( json_encode($types), true);
                $sheet->fromArray($data);             
            });
        })->export('xls');
    }
}
