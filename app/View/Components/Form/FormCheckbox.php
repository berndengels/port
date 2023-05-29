<?php

namespace App\View\Components\Form;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use ProtoneMedia\LaravelFormComponents\Components\Component;
//use Illuminate\View\Component;
use ProtoneMedia\LaravelFormComponents\Components\HandlesBoundValues;
use ProtoneMedia\LaravelFormComponents\Components\HandlesValidationErrors;

class FormCheckbox extends Component
{
    use HandlesValidationErrors;
    use HandlesBoundValues;

//	public string $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
		public string $name,
		public ?string $label = null,
		public $value = 1,
		public $bind = null,
		public bool $default = false,
		public bool $checked = false,
		public bool $inline = false,
		bool $showErrors = true,
        public ?string $class = null
    ) {
//		$this->name = $name;
		$inputName = static::convertBracketsToDots(Str::before($name, '[]'));

		if ($oldData = old($inputName)) {
			$this->checked = in_array($value, Arr::wrap($oldData));
		}

		if (!session()->hasOldInput() && $this->isNotWired()) {
			$boundValue = $this->getBoundValue($this->bind, $inputName);

			if ($boundValue instanceof Arrayable) {
				$boundValue = $boundValue->toArray();
			}

			if (is_array($boundValue)) {
				$this->checked = in_array($value, $boundValue);
				return;
			}

			$this->checked = is_null($boundValue) ? $this->default : $boundValue;
		}
    }

	protected function generateIdByName(): string
	{
		return "auto_id_" . $this->name . "_" . $this->value;
	}
}
