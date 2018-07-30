<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Juzgados Registrados</title>
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

    <h2 align="center">Listado de Juzgados Registrados</h2>

    <br>
   
    <table>
        <thead>
            <tr>
                <th bgcolor="#90CEF7">Nombre</th>
                <th bgcolor="#90CEF7">Abreviatura</th>
                <th bgcolor="#90CEF7">Ciudad</th>
                <th bgcolor="#90CEF7">Estado</th>

            </tr>    
        </thead>
        <tbody>
            @foreach($courts as $court)
                <tr>
                    <td>{{$court->nombre}}</td>
                    <td>{{$court->abreviatura}}</td>
                    <td>{{$court->ciudad}}</td>
                    <td>{{$court->estado}}</td>
                </tr>
            @endforeach
        </tbody>        
    </table>
  </body>
</html>