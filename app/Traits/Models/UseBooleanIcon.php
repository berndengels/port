<?php

namespace App\Traits\Models;

trait UseBooleanIcon
{
    public function icon($attribute, $selector = 'switch') {
        $cssClass = $this->$attribute ? 'text-xl text-green-600 fas fa-check-circle on' : 'text-xl text-red-600 fas fa-times off';
        return '<i class="' . $selector . ' ' . $cssClass . '"></i>';
    }
}
