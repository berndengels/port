<?php
namespace App\View\Components;

class NavionicsMap extends Map
{
    public $token;
    protected $view = 'components.navionics-map';

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param  string $token
     * @return NavionicsMap
     */
    public function setToken(string $token): NavionicsMap
    {
        $this->token = $token;
        $this->viewParams += ['token' => $this->token];
        return $this;
    }
}
