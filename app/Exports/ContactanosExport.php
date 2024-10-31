<?php

namespace App\Exports;

use App\Models\contactanos;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ContactanosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return contactanos::all()->map(function ($contact) {
            // Formatear la fecha de creación
            $date = new \DateTime($contact->created_at);
            $formattedDate = $date->format('d \d\e F \d\e Y \a \l\a\s h:i A'); // Ejemplo: "31 de octubre de 2024 a las 12:55 AM"

            return [
                $contact->id,
                $contact->nombre,
                $contact->apellidos,
                $contact->correo_electronico,
                $contact->telefono,
                $contact->mensaje,
                $formattedDate, // Usar la fecha formateada
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellidos',
            'Correo Electrónico',
            'Teléfono',
            'Mensaje',
            'Fecha de Creación',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Estilo para los encabezados
                $cellRange = 'A1:G1'; // Ajusta el rango según el número de columnas
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');

                // Estilo para el resto de las celdas
                $event->sheet->getDelegate()->getStyle('A2:G' . (contactanos::count() + 1))->getAlignment()->setVertical('top');
                $event->sheet->getDelegate()->getStyle('A2:G' . (contactanos::count() + 1))->getAlignment()->setHorizontal('left');

                // Ajustar el ancho de las columnas
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(30);// Ajustar el ancho para la fecha
            },
        ];
    }
}
