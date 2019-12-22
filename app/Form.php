<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

	protected $table = 'forms';

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $fillable = [
		'user_id',
		'name',
		'email',
		'slug',
		'domain',
		'enabled',
		'notify_by_email',
	];

	protected $casts = [
		'enabled'			=> 'boolean',
		'notify_by_email'	=> 'boolean',
	];

	protected $appends = [
		'url',
	];

	public function getUrlAttribute()
	{

		return config('app.url') . '/submit/' . $this->slug;

	}

	public function user() {

		return $this->belongsTo(User::class);

	}

	public function responses() {

		return $this->hasMany(Response::class);

	}

	public function scopeByUser($query, $id) {

		$query->where('user_id', $id);

	}

}
