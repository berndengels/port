<?php

namespace App\Exports;

use App\Models\CaravanDates;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CaravanDatesExport implements FromView
{
    public $data;
    public $count;
    public $priceTotal;
    public $year;
    public $month;

    public function __construct($year = null, $month = null)
    {
        $this->year     = $year;
        $this->month    = $month;
        $this->data     = $this->getData();
        $this->count    = $this->data->count();
        $this->priceTotal = $this->data->sum(
            function ($item) {
                return $item->price; 
            }
        );
    }

    public function getData()
    {
        $query = CaravanDates::with('caravan');

        if($this->year) {
            $query->whereRaw('YEAR(`from`) = ?', [$this->year]);
            if($this->month) {
                $query->whereRaw('MONTH(`from`) = ?', [$this->month]);
            }
        }

        $data = $query
            ->orderBy('from')
            ->get();
        return $data;
    }

    public function view(): View
    {
        return view(
            'caravanDates.export', [
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
