<?php

namespace App\Exports;

use App\Models\BoatDates;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class BoatDatesExport extends ExcelExport implements WithMapping, WithColumnFormatting
{
    protected $view  = 'admin.boatDates.export';
    protected $model = BoatDates::class;
    protected $with = 'boat';
    protected $headings = [
        'Bootsname',
        'Saison',
        'Von',
        'Bis',
        'Preis',
    ];

    public function map($row): array
    {
        return [
            $row->boat->name,
            $row->saison,
            $row->from->format('d.m.Y'),
            $row->until->format('d.m.Y'),
            $row->price,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => DataType::TYPE_STRING,
            'B' => DataType::TYPE_STRING,
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
