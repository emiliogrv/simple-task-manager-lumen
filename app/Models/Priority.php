<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model {
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes visibles from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = [
		'id',
		'name',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	public function visibles() {
		return implode(',', $this->visible);
	}
}