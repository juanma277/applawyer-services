<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        @foreach ($user as $data)
            <p>
                Hola, <strong>{{$data->nombre}}</strong> por favor sigue el siguiente link para recuperar tu contraseña :
            </p>

            <p>
                http://localhost:8000/
            </p>
       @endforeach
</body>
</html>