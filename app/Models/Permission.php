<?php
namespace App\Models;

use Spatie\Permission\Models\Permission as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BaseModel
{
    use HasFactory;
    protected $appends = ['actions','model','action','uniqName'];
    public $action;
    public $model;

    protected static $actions = [
        'read'  => 'read',
        'write' => 'write'
    ];

    public static function actions()
    {
        return self::$actions;
    }

    public function getUniqNameAttribute()
    {
        return $this->name . ' '  .$this->guard_name;
    }

    public static function getActionsAttribute()
    {
        return self::actions();
    }

    public function getModelAttribute()
    {
        return $this->model;
    }

    public function getActionAttribute()
    {
        return $this->action;
    }
}
