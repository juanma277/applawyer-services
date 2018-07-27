<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" type="text/css" href="css/app.css">
  </head>
  <body>

    <div class="logo">
        <img src="images/logo/logo-applawyer1.png" class="Imagen-logo">
        <img src="images/logo/logo-text-app-lawyer.png" class="Imagen-logo-text">

        <div class="datosEmpresa">
                <div class="tituloEmpresa">ZoneApps</div>
                <div>Cra 9 # 17 - 39</div>
                <div>Popayán - Cauca</div>
                <div>(602) 519-0450</div>
                <div><a href="applawyer@example.com">applawyer@example.com</a></div>
        </div>
    </div>

    <hr>

    <h2 align="center">Listado de Usuarios Registrados</h2>

    <br>
   
    <table>
        <thead>
            <tr>
                <th bgcolor="#90CEF7">Nombres</th>
                <th bgcolor="#90CEF7">Email</th>
                <th bgcolor="#90CEF7">Dirección</th>
                <th bgcolor="#90CEF7">Teléfono</th>
                <th bgcolor="#90CEF7">Profesión</th>
                <th bgcolor="#90CEF7">Role</th>
                <th bgcolor="#90CEF7">Estado</th>

            </tr>    
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->nombre}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->direccion}}</td>
                    <td>{{$user->telefono}}</td>
                    <td>{{$user->profesion}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->estado}}</td>
                </tr>
            @endforeach
        </tbody>        
    </table>
  </body>
</html>