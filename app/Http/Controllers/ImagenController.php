<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImagenController extends Controller
{
   
    // =========================================
    // Obtener imagen de Adjunto
    // =========================================
    public function adjunto($archivo)
    {
       echo "<img src='/images/adjuntos/".$archivo."'>";
    }

    
}
