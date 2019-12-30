<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'ends_at',
        'next_run'
    ];

    protected $table = 'subscriptions';

    protected $fillable = [
    	'user_id',
    	'name',
    	'stripe_id',
    	'stripe_plan',
    ];

    public function user() {

    	return $this->belongsTo(User::class);

    }
}
