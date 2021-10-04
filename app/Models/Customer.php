<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $table = 'customers';
    protected $guarded = ['id'];
    protected $hidden = ['password','remember_token'];
    public $timestamps = false;

}
