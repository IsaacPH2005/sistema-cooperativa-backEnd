<!DOCTYPE html>
<html>
<head>
    <title>Punto de Reclamo</title>
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
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Punto de Reclamo</h1>
    <table>
        <tr>
            <th>Campo</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Fecha del Hecho</td>
            <td>{{ $PuntoDeReclamo->fecha_del_hecho }}</td>
        </tr>
        <tr>
            <td>Agencia</td>
            <td>{{ $PuntoDeReclamo->agencia }}</td>
        </tr>
        <tr>
            <td>Descripción</td>
            <td>{{ $PuntoDeReclamo->descripcion }}</td>
        </tr>
        <tr>
            <td>Tipo de Persona</td>
            <td>{{ $PuntoDeReclamo->tipo_persona }}</td>
        </tr>
        <tr>
            <td>Nombre o Razón Social</td>
            <td>{{ $PuntoDeReclamo->nombre_o_razon_social }}</td>
        </tr>
        <tr>
            <td>Número de Documento</td>
            <td>{{ $PuntoDeReclamo->numero_de_documento }}</td>
        </tr>
        <tr>
            <td>Celular</td>
            <td>{{ $PuntoDeReclamo->celular }}</td>
        </tr>
        <tr>
            <td>Correo Electrónico</td>
            <td>{{ $PuntoDeReclamo->correo_electronico }}</td>
        </tr>
        <tr>
            <td>Dirección</td>
            <td>{{ $PuntoDeReclamo->direccion }}</td>
        </tr>
        <tr>
            <td>Complemento</td>
            <td>{{ $PuntoDeReclamo->complemento }}</td>
        </tr>
        <tr>
            <td>Expedido En</td>
            <td>{{ $PuntoDeReclamo->expedido_en }}</td>
        </tr>
        <tr>
            <td>Teléfono Fijo</td>
            <td>{{ $PuntoDeReclamo->telefono_fijo }}</td>
        </tr>
        <tr>
            <td>Recibir Número de Reclamo</td>
            <td>{{ $PuntoDeReclamo->recibir_numero_de_reclamo }}</td>
        </tr>
        <!-- Agrega más campos según sea necesario -->
    </table>
</body>
</html>