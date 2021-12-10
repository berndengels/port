<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FromViewExport implements FromView
{
    public $data;
    public $count;
    public $priceTotal;
    protected $view;
    protected $model;
    protected $with;
    protected $fromKey = 'from';

    public function __construct(public $year = null, public $month = null)
    {
        $this->data     = $this->getData();
        $this->count    = $this->data->count();
        $this->priceTotal = $this->data->sum(fn ($item) => $item->price);
    }

    public function getData()
    {
        $query = $this->with ? ($this->model)::with($this->with) : ($this->model);

        if($this->year) {
            $query->whereRaw("YEAR(`$this->fromKey`) = ?", [$this->year]);
            if($this->month) {
                $query->whereRaw("MONTH(`$this->fromKey`) = ?", [$this->month]);
            }
        }

        $data = $query
            ->orderBy($this->fromKey)
            ->get();
        return $data;
    }

    public function view(): View
    {
        return view(
            $this->view, [
                'data'          => $this->data,
                'priceTotal'    => $this->priceTotal,
            ]
        );
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return mixed|null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed|null
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }
}
