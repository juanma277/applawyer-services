<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Mail;

class MailController extends Controller
{
   // =========================================
    // Enviar email de recordar contraseña
    // =========================================
    public function rememberPassword(Request $request)
    {
        $email = $request->email;
        $users = DB::select("SELECT * FROM users WHERE email = '". $email ."'" );

        if(empty($users)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe un usuario registrado con ese email!'
            ]);
        }

        foreach ($users as $user){
            $info = array([
                'nombre' => $user->nombre,
                'email' => $user->email
            ]);
        }

        Mail::send('emails.password', ['user' => $users], function ($m) use ($email) {
            $m->from('applawyer@support.com', 'AppLawyer');
            $m->to($email)->subject('Recuperar Contraseña');
        });
        /*
        Mail::send('emails.password', $info, function($mjs, $email){
            $mjs->subject('Recuperar Contraseña') ;
            $mjs->to($email);
        });*/

        return response()->json([
            'error' => false,
            'Mensaje' => '¡Correo enviado correctamente!'
        ]);


        
        
    }
}
