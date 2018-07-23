<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Process;
use DB;

class pdfController extends Controller
{
    public function procesos($id){

        $process = DB::select("SELECT proceso.demandante, proceso.demandado, proceso.radicado, proceso.fecha, proceso.estado, tipo_proceso.nombre AS tipo, juzgado.nombre AS juzgado from proceso  JOIN tipo_proceso ON(tipo_proceso.id = proceso.tipo_proceso_id) JOIN juzgado ON (juzgado.id = proceso.juzgado_id) WHERE user_id=".$id);

        if(empty($process)){
            return response()->json([
                'error' => true,
                'cuenta' => count($process),
                'mensaje' => 'No existen procesos'
            ]);
        }

        $pdf = \PDF::loadView('pdf.procesos', ['process' => $process]);
        return $pdf->download('procesos.pdf');
    }
}
