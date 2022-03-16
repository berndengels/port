<?php

namespace App\Traits\Models;

trait UseBooleanSwitchIcon
{
    public function toggleSwitch($attribute, $selector = 'switch') {
        $cssClass = $this->$attribute ? 'text-xl text-green-600 fas fa-toggle-on on' : 'text-xl text-red-600 fad fa-toggle-off off';
        return '<i class="' . $selector . ' ' . $cssClass . '"></i>';
    }
}
