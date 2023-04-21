<?php

namespace App\View\Components\Navigation;

use App\Models\ConfigOffer;
use Illuminate\View\Component;

abstract class Main extends Component
{
    public $offers;
    public function __construct()
    {
        $this->offers = ConfigOffer::all()
            ->keyBy(fn($item) => class_basename($item->model))
            ->map(fn($item) => (bool) $item->enabled);
    }
}
