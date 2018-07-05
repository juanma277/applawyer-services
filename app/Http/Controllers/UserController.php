<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\User;


class UserController extends Controller
{
    // =========================================
    // Obtener todos los Usuarios
    // =========================================
    public function all()
    {
        $users = DB::select('SELECT * from users');

        if(empty($users)){
            return response()->json([
                'error' => true,
                'cuenta' => count($users),
                'mensaje' => 'No existen usuarios'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($users),
            'usuarios' => $users
        ]);
    }

    // =========================================
    // Obtener los Usuarios Paginados
    // =========================================
    public function paginate($desde=0)
    {   
        $users = DB::select('SELECT * from users LIMIT 10 OFFSET '.$desde);

        if(empty($users)){
            return response()->json([
                'error' => true,
                'cuenta' => count($users),
                'mensaje' => 'No existen usuarios'
            ]);
        }

        return response()->json([
            'error' => false,
            'cuenta' => count($users),
            'usuarios' => $users
        ]);
    }

    // =========================================
    // Crear Usuario
    // =========================================
    public function create(Request $request)
    {   
        try {
            $user = DB::table('users')->insert(
                [   
                    'nombre' => $request->nombres, 
                    'email' => $request->email,
                    'password' => \Hash::make($request->password),
                    'uid' => $request->uid,
                    'provider' => $request->provider,
                    'notificaciones' => $request->notificaciones,
                    'terminos' => $request->terminos
                ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario Creado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Obtener Usuario
    // =========================================
    public function getUser($id)
    {   
        $user = User::find($id);

        if(empty($user)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe usuario'
            ]);
        }

        return response()->json([
            'error' => false,
            'usuario' => $user
        ]);
    }

    // =========================================
    // Actualizar Usuario
    // =========================================
    public function update(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $user = User::find($id);
        if(empty($user)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe usuario'
            ]);
        }

        try {
            $user = DB::table('users')
            ->where('id', $id)
            ->update([
                        'nombre' => $request->nombres, 
                        'email' => $request->email,
                        'notificaciones' => $request->notificaciones
                    ]);

            $user = User::find($id);

            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario Actualizado',
                'usuario' => $user
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Actualizar Contraseña de Usuario
    // =========================================
    public function updatePassword(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $user = User::find($id);
        if(empty($user)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe usuario'
            ]);
        }

        try {
            $user = DB::table('users')
            ->where('id', $id)
            ->update([
                        'password' => \Hash::make($request->password)
                    ]);

            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario Actualizado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
            ]);
        }
    }

    // =========================================
    // Actualizar Imagen de Usuario
    // =========================================
    public function updateImagen(Request $request, $id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $user = User::find($id);
        if(empty($user)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe usuario'
            ]);
        }

        //VERIFICAR QUE SE ENVIA IMAGEN
        if($request->archivo === null){
            return response()->json([
                'error' => true,
                'mensaje' => 'No hay selección de imagen'
            ]);            
        }

            $imagen = explode(',', $request->archivo );
            $data = base64_decode($imagen[1]);
            $archivo = $id."-".rand().".png";
            $filepath = public_path('images/users/'.$archivo);

            file_put_contents($filepath, $data);

            try {
                $user = DB::table('users')
                ->where('id', $id)
                ->update([
                            'imagen' => $archivo
                        ]);
                
                $user = User::find($id);
    
                return response()->json([
                    'error' => false,
                    'mensaje' => 'Imagen de Usuario Actualizada',
                    'usuario' => $user
                ]);
            
            } catch (\Illuminate\Database\QueryException $e){
                return response()->json([
                    'error' => true,
                    'mensaje' => 'Faltan datos requeridos o se encuentran duplicados'
                ]);
            }
    }

    // =========================================
    // Eliminar Usuario
    // =========================================
    public function delete($id)
    {  
        //VERIFICAR QUE EXISTE EL USUARIO
        $user = User::find($id);
        if(empty($user)){
            return response()->json([
                'error' => true,
                'mensaje' => 'No existe usuario'
            ]);
        }

        try {
            DB::table('users')->where('id', '=', $id)->delete();

            return response()->json([
                'error' => false,
                'mensaje' => 'Usuario Eliminado'
            ]);
        
        } catch (\Illuminate\Database\QueryException $e){
            return response()->json([
                'error' => true,
                'mensaje' => 'Ha ocurrido un error por favor intentalo nuevamente'
            ]);
        }
    }

    
}
