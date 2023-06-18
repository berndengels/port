<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainFormRequest extends FormRequest
{
    protected $modelName;
    protected $routeParam;
	protected $decimalFields;
	protected $booleanFields;
	protected $defaults;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        if(!$this->routeParam) {
            $this->routeParam = lcfirst($this->modelName);
        }
    }

	protected function prepareForValidation()
	{
		// z.B Preise
		$this->handleDecimals();
		// z.B: Checkboxen, true/false Werte
		$this->handleBooleans();
		// Default Werte setzen
		$this->handleDefaults();
	}

	/**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    protected function getId()
    {
        $route = $this->route($this->routeParam);
        if($route) {
            return $route->id;
        }
        return null;
    }

	private function handleDecimals()
	{
		// aus 2000,50 wird 20005.00
		if($this->decimalFields) {
			foreach($this->decimalFields as $field) {
				$decimal = trim(str_replace('€', '', $this->$field));
				$decimal = preg_replace("/^([^,]+)([\.,])([\d]{2})$/","$1.$3", $decimal);

				if(preg_match("/^([\d\.]+)\.([\d]{2})$/", $decimal)) {
					$arr = explode(".", $decimal);
					if(count($arr) > 2) {
						$last = array_pop($arr);
						$first = implode('', $arr);
						$decimal = $first.'.'.$last;
					}
				} else if (preg_match("/^([\d]+)([\.])([\d]+)$/", $decimal)) {
					$decimal = str_replace('.', '', $decimal);
				}

				$this->merge([
					$field	=> $decimal,
				]);
			}
		}
	}

	private function handleBooleans()
	{
		if($this->booleanFields) {
			foreach($this->booleanFields as $field) {
				$this->merge([
					$field	=> isset($this->$field) ? 1 : 0,
				]);
			}
		}
	}

	private function handleDefaults()
	{
		if($this->defaults) {
			foreach ($this->defaults as $field => $value) {
				$this->merge([
					$field	=> $value,
				]);
			}
		}
	}
}
