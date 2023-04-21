<?php

namespace App\Exports;

use App\Libs\Prices\PriceCalculator;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExport implements WithHeadings, ShouldAutoSize, FromQuery
{
    use Exportable;

    public $data;
    public $count;
    public $brutto;
    public $netto;
    public $mwst;
    public $settings;

    protected $headings = [];
    protected $model;
    protected $with;

    protected $sumField = 'price';
    protected $fromKey = 'from';

    /**
     * @param $data
     * @param $priceTotal
     * @param $model
     * @param $with
     * @param string $fromKey
     */
    public function __construct(public ?Carbon $from = null, public ?Carbon $until = null)
    {
        $this->settings = config('settings');
        $this->query();
    }

    public function headings(): array
    {
        if(is_array($this->headings)) {
            return $this->headings;
        }
        return [];
    }

    public function query()
    {
        $query = $this->with ? ($this->model)::with($this->with) : ($this->model);
        $query
            ->datesBetween($this->from, $this->until)
            ->orderBy($this->fromKey)
        ;
        $this->data     = $query->get();
        $this->count    = $this->data->count();
        $this->brutto   = $this->data->sum(fn ($item) => $item->{$this->sumField});
        $this->netto    = PriceCalculator::nettoPrice($this->brutto);
        $this->mwst     = $this->brutto - $this->netto;

        return $query;
    }
}
