<?php

namespace App\Exports;

use App\Models\PuntoDeReclamo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PuntoDeReclamoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PuntoDeReclamo::all()->map(function ($item) {
            // Formatear la fecha de creación
            $date = new \DateTime($item->created_at);
            $formattedDate = $date->format('d \d\e F \d\e Y \a \l\a\s h:i A'); // Ejemplo: "31 de octubre de 2024 a las 12:55 AM"

            return [
                $item->id, // Asegúrate de incluir el ID
                $item->fecha_del_hecho,
                $item->categoria,
                $item->sub_categoria,
                $item->monto_comprometido,
                $item->opciones_multiples_1,
                $item->agencia,
                $item->descripcion,
                $item->tipo_persona,
                $item->representante_legal,
                $item->numero_de_testimonio,
                $item->nombre_o_razon_social,
                $item->numero_de_documento,
                $item->opciones_multiples_2,
                $item->complemento,
                $item->expedido_en,
                $item->celular,
                $item->correo_electronico,
                $item->direccion,
                $item->medio_de_envio_de_respuesta,
                $item->telefono_fijo,
                $item->recibir_numero_de_reclamo,
                $formattedDate, // Usar la fecha formateada
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha del hecho',
            'Categoria',
            'Sub Categoria ',
            'Monto comprometido',
            'Opciones Multiples 1',
            'Agencia',
            'Descripcion',
            'Tipo Persona',
            'Representante Legal',
            'Numero de Testimonio',
            'Nombre o Razon Social',
            'Numero de Documento',
            'Opciones Multiples 2',
            'Complemento',
            'Expedido en',
            'Celular',
            'Correo Electronico',
            'Direccion',
            'Medio de Envio de Respuesta',
            'Telefono Fijo',
            'Recibir Numero de Reclamo',
            'Fecha de creacion'
        ];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            // Estilo para los encabezados
            $cellRange = 'A1:W1'; // Ajusta el rango según el número de columnas
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
            $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->getStartColor()->setARGB('FFCCCCCC'); // Color de fondo gris claro

            // Estilo para el resto de las celdas
            $event->sheet->getDelegate()->getStyle('A2:V' . (PuntoDeReclamo::count() + 1))->getAlignment()->setVertical('top');
            $event->sheet->getDelegate()->getStyle('A2:V' . (PuntoDeReclamo::count() + 1))->getAlignment()->setHorizontal('left');

            // Ajustar el ancho de las columnas
            foreach (range('A', 'V') as $column) {
                $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true); // Ajustar automáticamente el ancho de las columnas
            }

            // Habilitar el ajuste de texto en las celdas
            $event->sheet->getDelegate()->getStyle('A2:V' . (PuntoDeReclamo::count() + 1))->getAlignment()->setWrapText(true);
        },
    ];
}
}
