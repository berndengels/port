<?php

namespace App\Traits\Models;

trait UseBooleanIcon
{
    public function icon($attribute, $selector = 'switch') {
        $css = 'fs-3 fas ' . ($this->$attribute ? 'green fa-toggle-on on' : 'grey fa-toggle-off off');
        return '<i class="' . $selector . ' ' . $css . '"></i>';
    }
}
