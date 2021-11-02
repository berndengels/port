<?php
namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * App\Models\Model
 *
 * @method static Builder|Model newModelQuery()
 * @method static Builder|Model newQuery()
 * @method static Builder|Model query()
 * @mixin Eloquent
 */
class Model extends BaseModel
{
    use HasFactory;
    public function __construct(array $attributes = [])
    {
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
        parent::__construct($attributes);
    }}
