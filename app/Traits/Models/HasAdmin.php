<?php

namespace App\Traits\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait HasAdmin
{
	/**
	 * The "booted" method of the model.
	 */
	protected static function booted(): void
	{
		static::created(function (Model $model) {
			if(auth('admin')->check()) {
				$model->created_by = auth('admin')->user()->id;
			}
		});
		static::updated(function (Model $model) {
			if(auth('admin')->check()) {
				$model->updated_by = auth('admin')->user()->id;
			}
		});
	}

	public function createdBy() {
		return $this->belongsTo(User::class, 'created_by', 'id');
	}

	public function updatedBy() {
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}
}