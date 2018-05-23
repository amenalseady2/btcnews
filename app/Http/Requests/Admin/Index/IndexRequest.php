<?php

namespace App\Http\Requests\Admin\Index;
use Illuminate\Foundation\Http\FormRequest;
class IndexRequest extends FormRequest
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
            'email'     => 'required|email',
            'password'  => 'required|string',
        ];
    }

    public function messages()
    {   
        return [
            'email.required'    => trans('indexRequest.email'),
            'email.email'       => trans('indexRequest.emailNotice'),
            'password.required' => trans('indexRequest.password'),
            'password.string'   => trans('indexRequest.passwordNotice'),
        ];
    }
}
