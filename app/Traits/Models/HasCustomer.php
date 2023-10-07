<?php

namespace App\Traits\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

trait HasCustomer
{
	/**
	 * The "booted" method of the model.
	 */
	protected static function booted(): void
	{
		static::creating(function (self $model) {
			if(auth('customer')->check()) {
				$model->created_by = auth('customer')->user()->id;
			}
		});
		static::updating(function (self $model) {
			if(auth('customer')->check()) {
				$model->updated_by = auth('customer')->user()->id;
			}
		});
	}

	public function createdBy() {
		return $this->belongsTo(Customer::class, 'created_by', 'id');
	}

	public function updatedBy() {
		return $this->belongsTo(Customer::class, 'updated_by', 'id');
	}
}