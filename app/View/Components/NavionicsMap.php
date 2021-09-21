<?php
namespace App\View\Components;

class NavionicsMap extends Map
{
    public $token;
    protected $view = 'components.navionics-map';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(float $lat, float $lng, int $zoom, string $token)
    {
        $this->token    = $token;
        parent::__construct($lat, $lng, $zoom);
        $this->viewParams += ['token' => $this->token];
    }
}
