<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BaseModel
 *
 * @method static Builder|BaseModel newModelQuery()
 * @method static Builder|BaseModel newQuery()
 * @method static Builder|BaseModel query()
 * @mixin Eloquent
 */
class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // For unit tests
        switch(config('app.env')) {
        case 'testing':
            $this->setConnection('testing');
            break;
        case 'demo':
        case 'dusk.local':
            $this->setConnection('demo');
            break;
        default:
            $this->setConnection('mysql');
        }
    }
}
