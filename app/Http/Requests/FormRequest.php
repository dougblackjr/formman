<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'           => 'required|',
            'name'              => 'required|string',
            'email'             => 'required|email',
            'domain'            => '',
            'enabled'           => 'boolean',
            'notify_by_email'   => 'boolean',
            'webhook_url'       => '',
        ];
    }
}
