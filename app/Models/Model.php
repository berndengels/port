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
        parent::__construct($attributes);
        $user = auth('admin')->user();
        $this->connection = ($user && 'test@test.com' === $user->email) ? 'test' : 'port';
    }
}
