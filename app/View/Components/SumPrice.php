<?php

namespace App\View\Components;

use Carbon\Carbon;
use App\Libs\Prices\PriceCalculator;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class SumPrice extends Component
{
    public $netto;
    public $mwst;
    public ?Carbon $from = null;

    /**
     * Create a new component instance.
     * @param Request $request
     * @param int $brutto
     * @return void
     */
    public function __construct(
        private Request $request,
        public int $brutto,
        public ?string $title = 'Summe Einnahmen',
        public ?string $class = null
    )
    {
        $this->netto = PriceCalculator::nettoPrice($this->brutto);
        $this->mwst  = $this->brutto - $this->netto;
        $year        = $request::input('year');
        $month       = $request::input('month');

        if($year) {
            $this->from = Carbon::createFromDate(year: $year)->startOfYear();
            if($month) {
                $this->from = Carbon::createFromDate(year: $year, month: $month)->startOfMonth();
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sum-price', [
            'brutto'    => $this->brutto,
            'netto'     => $this->netto,
            'title'     => $this->title,
            'class'     => $this->class,
            'mwst'      => $this->mwst,
            'from'      => $this->from,
        ]);
    }
}
