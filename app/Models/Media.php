<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseModel;
class Media extends BaseModel
{
    protected $table = 'media';
	protected $guarded = ['id'];
}
