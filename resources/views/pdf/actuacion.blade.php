<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Actuaciones</title>
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

    <div class="datosProceso">
        @foreach($datosProceso as $data)
            <div>{{$data->radicado}}<div>
            <div>{{$data->ciudad}} - {{$data->juzgado}}</div>
            <div>{{$data->demandante}} - {{$data->demandado}}</div>
            <div>{{$data->fecha}}</div>
        @endforeach
    </div>

    <br>
   
    <table>
        <thead>
            <tr>
                <th bgcolor="#90CEF7">Actuación</th>
                <th bgcolor="#90CEF7">Anotación</th>
                <th bgcolor="#90CEF7">Fecha</th>
            </tr>    
        </thead>
        <tbody>
            @foreach($process as $proceso)
                <tr>
                    <td>{{$proceso->actuacion}}</td>
                    <td>{{$proceso->anotacion}}</td>
                    <td>{{$proceso->fecha}}</td>
                </tr>
            @endforeach
        </tbody>        
    </table>
  </body>
</html>