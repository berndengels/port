<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasPersonName
{
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->firstname.' '.$this->lastname
        );
    }

    protected function nameReverse(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lastname.', '.$this->firstname
        );
    }

	protected function nameRevers(): Attribute
	{
		return $this->nameReverse();
	}
}
