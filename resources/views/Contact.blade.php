<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Mensajes de Contacto</h1>
        @foreach($contactanos as $contacto)
            <div class="mensaje">
                <strong>{{ $contacto->nombre }} {{ $contacto->apellidos }}</strong>
                <p>{{ $contacto->mensaje }}</p>
                <p><em>{{ $contacto->correo_electronico }}</em></p>
            </div>
        @endforeach
    </div>
    @endsection
</body>

</html>
