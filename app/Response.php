<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';

    protected $dates = [
    	'created_at',
    	'updated_at',
    	'deleted_at',
    ];

    protected $fillable = [
    	'form_id',
        'ip_address',
    	'data',
    	'is_spam',
    	'is_active',
    ];

    protected $casts = [
    	'data'		=> 'array',
    	'is_spam'	=> 'boolean',
    	'is_active'	=> 'boolean',
    ];

    public function form() {
    	return $this->belongsTo(Form::class);
    }
}
