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

    <div class="datosCliente">
            <div class="name">John Doe<div>
            <div class="address">796 Silver Harbour, TX 79273, US</div>
            <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
    </div>

    <br>
   
    <table>
        <thead>
            <tr>
                <th>Radicado</th>
                <th>Demandante</th>
                <th>Demandado</th>
                <th>Tipo Proceso</th>
                <th>Juzgado</th>
                <th>Estado</th>
            </tr>    
        </thead>
        <tbody>
            @foreach($process as $proceso)
                <tr>
                    <td>{{$proceso->radicado}}</td>
                    <td>{{$proceso->demandante}}</td>
                    <td>{{$proceso->demandado}}</td>
                    <td>{{$proceso->tipo}}</td>
                    <td>{{$proceso->juzgado}}</td>
                    <td>{{$proceso->estado}}</td>
                </tr>
            @endforeach

        </tbody>        
    </table>

    <footer>
            <h2>ZoneApps</h2>
            <div>Cra 9 # 17 - 39, Popayán - Cauca</div>
            <div>(602) 519-0450</div>
            <div><a href="applawyer@example.com">applawyer@example.com</a></div>
    </footer>
  </body>
</html>