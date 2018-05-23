<?php
namespace App\Http\Requests\Admin\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Admin;

class StoreRequest extends FormRequest
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
  
    protected function getValidatorInstance()
    {
        $validatorInstance = parent::getValidatorInstance();
        $validatorInstance->addExtension('verifyEmail', function($attribute, $value, $parameters, $validator) {
            return Admin::verifyStoreAdminUserEmail($value);
        });
        return $validatorInstance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        return [
            'email'      => 'verifyEmail',
            'password'   => 'required|string|max:20',
        ];
    }

    public function messages()
    {

        return [
            'email.verify_email'    => trans('adminRequest.emailError'),
            'password.required'     => trans('adminRequest.passNull'),    
            'password.string'       => trans('adminRequest.passString'),
            'password.max'          => trans('adminRequest.passLength'),
        ];
    }

}
