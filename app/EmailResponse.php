<?php

namespace App;

use App\Form;
use Illuminate\Database\Eloquent\Model;

class EmailResponse extends Model
{
    protected $table = 'email_responses';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'form_id',
        'subject',
        'template',
        'json_template',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
