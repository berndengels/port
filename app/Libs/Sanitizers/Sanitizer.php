<?php
namespace App\Libs\Sanitizers;

use Illuminate\Database\Eloquent\Collection;

class Sanitizer
{
    protected static $model;
    /**
     * @var Collection|null
     */
    protected $data;

    /**
     * @return Collection|null
     */
    public function getData()
    {
        $this->data = (static::$model)::all();
        return $this->data;
    }
}
