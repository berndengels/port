<?php

namespace App\Traits\Models;

trait UseBooeanlIcon
{
    public function icon($attribute) {
        $cssClass = $this->$attribute ? 'text-xl text-green-600 fas fa-check-circle' : 'text-xl text-red-600 fas fa-times';

        return '<i class="' . $cssClass . '"></i>';
    }
}
