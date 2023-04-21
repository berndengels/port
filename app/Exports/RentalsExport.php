<?php

namespace App\Exports;

use App\Libs\Prices\PriceCalculator;
use App\Models\Rentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class RentalsExport extends ExcelExport implements WithMapping, WithColumnFormatting
{
    protected $view  = 'admin.rentals.export';
    protected $model = Rentable::class;
    protected $headings = [
        'Objekt',
        'Typ',
        'Von',
        'Bis',
        'Tage',
        'Preis',
    ];

    public function __construct(public $rentable, public ?Carbon $from = null, public ?Carbon $until = null)
    {
        parent::__construct($from, $until);
    }

    public function query()
    {
        $class =Relation::getMorphedModel($this->rentable);
        $query = ($this->model)::whereHasMorph('rentable', $class)
            ->datesBetween($this->from, $this->until)
            ->orderBy($this->fromKey)
        ;

        $this->data = $query->get();
        $this->count = $this->data->count();
        $this->brutto   = $this->data->sum(fn ($item) => $item->{$this->sumField});
        $this->netto    = PriceCalculator::nettoPrice($this->brutto);
        $this->mwst     = $this->brutto - $this->netto;

        return $query;
    }
    public function map($row): array
    {
        $days = ($row->from)->diffInDays($row->until);
        return [
            $row->rentable->name,
            __(ucfirst($this->rentable)),
            $row->from->format('d.m.Y'),
            $row->until->format('d.m.Y'),
            $days,
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
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
