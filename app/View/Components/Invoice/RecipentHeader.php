<?php

namespace App\View\Components\Invoice;

use App\Models\Customer;
use Illuminate\View\Component;

class RecipentHeader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Customer $recipient,
        public ?string $class = null
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invoice.recipent-header');
    }
}
