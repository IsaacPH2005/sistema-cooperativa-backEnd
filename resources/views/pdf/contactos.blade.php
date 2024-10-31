<!DOCTYPE html>
<html>
<head>
    <title>Lista de Contactos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Contactos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Mensaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contactos as $contacto)
            <tr>
                <td>{{ $contacto->id }}</td>
                <td>{{ $contacto->nombre }}</td>
                <td>{{ $contacto->apellidos }}</td>
                <td>{{ $contacto->correo_electronico }}</td>
                <td>{{ $contacto->telefono }}</td>
                <td>{{ $contacto->mensaje }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>