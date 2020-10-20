<?php

namespace App;

use App\Enums\Integrations;
use App\Form;
use Illuminate\Database\Eloquent\Model;

class FormIntegration extends Model
{
    protected $table = 'form_integrations';

    protected $dates = [
    	'created_at',
    	'updated_at',
    ];

    protected $fillable = [
    	'form_id',
    	'data',
    	'active',
    ];

    protected $casts = [
    	'data'		=> 'array',
    	'active'	=> 'boolean',
    ];

    protected $appends = [
    	'type_data'
    ];

    public function scopeActive($query)
    {
    	$query->where('active', true);
    }

    public function getTypeDataAttribute()
    {
    	if(!isset($this->data['type'])) {
    		return [];
    	}

    	$data = Integrations::getByKey($this->data['type']) ?? [];

    	return $data;
    }

    public function form()
    {
    	return $this->belongsTo(Form::class);
    }
}