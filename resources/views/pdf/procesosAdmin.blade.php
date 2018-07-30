<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Mis Procesos</title>
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

    <br>
   
    <table>
        <thead>
            <tr>
                <th bgcolor="#90CEF7">Radicado</th>
                <th bgcolor="#90CEF7">Usuario</th>
                <th bgcolor="#90CEF7">Demandante</th>
                <th bgcolor="#90CEF7">Demandado</th>
                <th bgcolor="#90CEF7">Tipo Proceso</th>
                <th bgcolor="#90CEF7">Juzgado</th>
                <th bgcolor="#90CEF7">Fecha</th>
                <th bgcolor="#90CEF7">Estado</th>
            </tr>    
        </thead>
        <tbody>
            @foreach($process as $proceso)
                <tr>
                    <td>{{$proceso->radicado}}</td>
                    <td>{{$proceso->usuario}}</td>
                    <td>{{$proceso->demandante}}</td>
                    <td>{{$proceso->demandado}}</td>
                    <td>{{$proceso->tipo}}</td>
                    <td>{{$proceso->juzgado}}</td>
                    <td>{{$proceso->fecha}}</td>
                    <td>{{$proceso->estado}}</td>
                </tr>
            @endforeach
        </tbody>        
    </table>
  </body>
</html>