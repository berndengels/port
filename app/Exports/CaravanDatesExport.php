<?php

namespace App\Exports;

use App\Models\CaravanDates;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CaravanDatesExport implements FromView
{
    private $from;
    private $until;
    private $data;

    public function __construct($from = null, $until = null)
    {
        $this->from     = $from;
        $this->until    = $until;
        $this->data     = $this->getData($this->from);
    }

    private function getData($from = null)
    {
        $query = CaravanDates::with('caravan');
        if($from) {
            $query->whereDate('from','>=', $from);
        }
        $data = $query
            ->orderBy('from')
            ->get()
        ;
        return $data;
    }

    public function view(): View
    {
        $priceTotal = $this->data->sum(function ($item){ return $item->price; });
        return view('caravanDates.export', [
            'data'          => $this->data,
            'priceTotal'    => $priceTotal,
        ]);
    }
}
