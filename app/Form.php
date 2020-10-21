<?php

namespace App;

use App\FormIntegration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{

	use SoftDeletes;

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
		'secret',
		'domain',
		'enabled',
		'notify_by_email',
		'webhook_url',
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

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function responses()
	{
		return $this->hasMany(Response::class);
	}

	public function scopeByUser($query, $id)
	{
		$query->where('user_id', $id);
	}

	public function scopeBySlug($query, $slug)
	{
		$query->where('slug', $slug);
	}

	public function integrations()
	{
		return $this->hasMany(FormIntegration::class);
	}

	public function scopeBySecret($query, $secret) {

		$query->where('secret', $secret);

	}

}
