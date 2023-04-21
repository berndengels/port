<?php

namespace App\View\Components\Form;

use ProtoneMedia\LaravelFormComponents\Components\FormSelect as BaseFormSelect;

class FormSelect extends BaseFormSelect
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $label = '',
        public $options = [],
        public $bind = null,
        public $default = null,
        public bool $multiple = false,
        public $showErrors = true,
        public $manyRelation = false,
        public bool $floating = false,
        public string $placeholder = '',
        public $inline = null,
        public ?string $class = null,
        public ?string $help = null
    )
    {
        parent::__construct(
            name: $name,
            label: $label,
            options: $options,
            bind: $bind,
            default: $default,
            multiple: $multiple,
            showErrors: $showErrors,
            manyRelation: $manyRelation,
            floating: $floating,
            placeholder: $placeholder
        );
    }
}
