<?php

namespace App\View\Components\Invoice;

use App\Models\ConfigSetting;
use Illuminate\View\Component;

abstract class Main extends Component
{
    public ConfigSetting $settings;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?string $class = null)
    {
        $this->settings = ConfigSetting::firstOrFail();
    }
}
