<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;


class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function log(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                'error' => false,
                'mensaje' => 'Datos Correctos',
                'usuario' => Auth::user()
            ]);
        }else{
            return response()->json([
                'error' => true,
                'mensaje' => 'Datos Incorrectos',
            ]);
        }
    }


    public function logout()
    {
        Auth::logout();
        return response()->json([
            'error' => false,
            'mensaje' => 'Sesion Teminada',
        ]);

    }
    
}
