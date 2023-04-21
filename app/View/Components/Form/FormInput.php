<?php

namespace App\View\Components\Form;

use Illuminate\Contracts\Support\MessageBag;
use ProtoneMedia\LaravelFormComponents\Components\FormInput as BaseFormInput;
use ProtoneMedia\LaravelFormComponents\Components\HandlesDefaultAndOldValue;
use ProtoneMedia\LaravelFormComponents\Components\HandlesValidationErrors;

class FormInput extends BaseFormInput
{
    use HandlesValidationErrors;
    use HandlesDefaultAndOldValue;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $label = '',
        public string $type = 'text',
        public ?string $bind = null,
        public ?string $default = null,
        public ?string $language = null,
        public ?string $placeholder = null,
        public bool $floating = false,
        public ?string $inline = null,
        public ?string $class = null,
        public ?string $help = null
    )
    {
        parent::__construct(
            name: $name,
            label: $label,
            type: $type,
            bind: $bind,
            default: $default,
            language: $language,
            floating: $floating
        );
    }
}
