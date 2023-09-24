<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Filter extends Component
{
    public $selectedKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public array|Collection $options,
        public ?string $id = null,
        public ?string $class = null,
        public ?string $val = null,
        public ?bool $inline = false,
        public ?bool $floating = false
    )
    {
        $this->selectedKey = $val;
    }

    public function isSelected($key): bool
    {
        return in_array($key, Arr::wrap($this->selectedKey));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.form.filter');
    }
}
