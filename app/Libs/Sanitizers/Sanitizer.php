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

    public function __construct()
    {
        $this->data = (static::$model)::all();
    }

    /**
     * @return Collection|null
     */
    public function getData()
    {
        return $this->data;
    }
}
