<!DOCTYPE html>
<html>
<head>
    <title>Punto de Reclamo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex; /* Utiliza flexbox para alinear el logo y el contenido */
        }
        .logo {
            flex: 0 0 auto; /* No permite que el logo crezca o se encoja */
            margin-right: 20px; /* Espacio entre el logo y el contenido */
        }
        .content {
            flex: 1; /* Permite que el contenido ocupe el espacio restante */
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
    <div class="logo">
        <img src="{{$logo}}" alt="Logo" width="200" height="200"> <!-- Ajusta el tamaño según sea necesario -->
    </div>
    <div class="content">
        <h1>Punto de Reclamo {{ $PuntoDeReclamo->pr_web}} {{$PuntoDeReclamo->id}}</h1>
        <table>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>Fecha del registro</td>
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
                <td>Complemento</td>
                <td>{{ $PuntoDeReclamo->complemento }}</td>
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
            <!-- Agrega más campos según sea necesario -->
        </table>
        <span>
            «En el plazo de cinco (5) días hábiles administrativos a partir del día de mañana, usted recibirá la carta de respuesta a su reclamo a través del medio que haya requerido o puede apersonarse por la Entidad Financiera a recoger su respuesta»
        </span>
    </div>
</body>
</html>