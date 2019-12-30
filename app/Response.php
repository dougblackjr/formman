<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{

    use SoftDeletes;

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
    	'is_spam'	=> 'boolean',
    	'is_active'	=> 'boolean',
        'data'      => 'array',
    ];

    public function form() {
    	return $this->belongsTo(Form::class);
    }

    public function scopeInThisMonth($query) {

        $now = now();

        $monthStart = $now->startOfMonth();

        $monthEnd = $now->endOfMonth();

        $query->whereBetween('created_at', [$monthStart, $monthEnd]);

    }
}
