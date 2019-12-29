<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

class FormRequest extends LaravelFormRequest
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
            'name'              => 'required|string',
            'email'             => 'required|email',
            'domain'            => 'nullable|url',
            'enabled'           => 'boolean',
            'notify_by_email'   => 'boolean',
            'webhook_url'       => 'nullable|url',
        ];
    }
}
