<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExport implements WithHeadings, ShouldAutoSize, FromQuery
{
    use Exportable;

    public $data;
    public $count;
    public $priceTotal;

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
    public function __construct(public $year = null, public $month = null)
    {
/*
        $this->data     = $this->getData();
        $this->count    = $this->data->count();
        $this->priceTotal = $this->data->sum(fn ($item) => $item->{$this->sumField});
*/
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

        if($this->year) {
            $query->whereRaw("YEAR(`$this->fromKey`) = ?", [$this->year]);
            if($this->month) {
                $query->whereRaw("MONTH(`$this->fromKey`) = ?", [$this->month]);
            }
        }

        $query->orderBy($this->fromKey);

        $data = $query->get();

        $this->count = $data->count();
        $this->priceTotal = $data->sum(fn ($item) => $item->{$this->sumField});

        return $query;
    }
}
