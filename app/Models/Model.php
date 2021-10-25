<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\DB;

class Model extends BaseModel
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $user = auth('admin')->user();
        $this->connection = ($user && 'test@test.com' === $user->email) ? 'mysql-test' : 'mysql';
    }
}
