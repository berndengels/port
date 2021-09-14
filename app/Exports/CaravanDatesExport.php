<?php

namespace App\Exports;

use App\Models\CaravanDates;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CaravanDatesExport implements FromView
{
    public $from;
    public $until;
    public $data;
    public $count;
    public $priceTotal;

    public function __construct($from = null, $until = null)
    {
        $this->from     = $from;
        $this->until    = $until;
        $this->data     = $this->getData();
        $this->count    = $this->data->count();
        $this->priceTotal = $this->data->sum(function ($item){ return $item->price; });
    }

    public function getData()
    {
        $query = CaravanDates::with('caravan');
        if($this->from) {
            $query->whereDate('from','>=', $this->from);
        }
        if($this->until) {
            $query->whereDate('until','<=', $this->until);
        }
        $data = $query
            ->orderBy('from')
            ->get()
        ;
        return $data;
    }

    public function view(): View
    {
        return view('caravanDates.export', [
            'data'          => $this->data,
            'priceTotal'    => $this->priceTotal,
        ]);
    }

    /**
     * @return mixed|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed|null
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @return mixed
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }
}
