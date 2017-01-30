<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject, AuthenticatableContract, AuthorizableContract {
	use Authenticatable, Authorizable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	/**
	 * The attributes visibles from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visibles = [
		'id',
		'first_name',
		'last_name',
		'email',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
	 * The relations to eager load on something query.
	 *
	 * @var array
	 */
	protected $includes = [
		'tasks',
	];

	public function visibles() {
		return implode(',', $this->visibles);
	}

	public function includes() {
		return implode(',', $this->includes);
	}

	public function tasks() {
		return $this->hasMany(Task::class, 'assigned_to', 'id');
	}

	public function getJWTIdentifier() {
		return $this->getKey();
	}

	public function getJWTCustomClaims() {
		return [];
	}

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = app('hash')->make($value);
	}
}