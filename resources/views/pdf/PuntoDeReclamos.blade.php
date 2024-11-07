<!DOCTYPE html>
<html>
<head>
    <title>Lista de Contactos</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Reducir el tamaño de la fuente */
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto; /* Permitir que las columnas se ajusten automáticamente */
        }
        th, td {
            border: 1px solid #000;
            padding: 4px; /* Reducir el padding */
            text-align: left;
            word-wrap: break-word; /* Permitir que el texto se divida en varias líneas */
        }
        th {
            background-color: #f2f2f2;
        }
        @page {
            margin: 50px 25px; /* Ajustar márgenes */
        }
        .header {
            position: fixed;
            top: -40px; /* Ajustar según sea necesario */
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: -30px; /* Ajustar según sea necesario */
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
        }
        .page-number {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>Puntos de Reclamos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha del hecho</th>
                <th>Categoria</th>
                <th>Sub Categoria</th>
                <th>Monto Comprometido</th>
                <th>Opciones Multiples</th>
                <th>Agencia</th>
                <th>Descripcion</th>
                <th>Tipo de Persona</th>
                <th>Representante legal</th>
                <th>Numero de Testimonio</th>
                <th>Nombre o razon social</th>
                <th>Numero de documento</th>
                <th>Opciones Multiples</th>
                <th>Complemeto</th>
                <th>Expedido en</th>
                <th>Celular</th>
                <th>Correo Electronico</th>
                <th>Direccion</th>
                <th>Medio de envio de respuesta</th>
                <th>Telefono fijo</th>
                <th>Recibir Nro de reclamo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($PuntoDeReclamos as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->fecha_del_hecho }}</td>
                <td>{{ $item->categoria }}</td>
                <td>{{ $item->sub_categoria }}</td>
                <td>{{ $item->monto_comprometido }}</td>
                <td>{{ $item->opciones_multiples_1 }}</td>
                <td>{{ $item->agencia }}</td>
                <td>{{ $item->descripcion }}</td>
                <td>{{ $item->tipo_persona }}</td>
                <td>{{ $item->representante_legal }}</td>
                <td>{{ $item->numero_de_testimonio }}</td>
                <td>{{ $item->nombre_o_razon_social }}</td>
                <td>{{ $item->numero_de_documento }}</td>
                <td>{{ $item->opciones_multiples_2 }}</td>
                <td>{{ $item->complemento }}</td>
                <td>{{ $item->expedido_en }}</td>
                <td>{{ $item->celular }}</td>
                <td>{{ $item->correo_electronico }}</td>
                <td>{{ $item->direccion }}</td>
                <td>{{ $item->medio_de_envio_de_respuesta }}</td>
                <td>{{ $item->telefono_fijo }}</td>
                <td>{{ $item->recibir_numero_de_reclamo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>