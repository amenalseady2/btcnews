<?php
namespace App\Http\Requests\Admin\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Admin;

class UpdateRequest extends FormRequest
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

    protected function validationData()
    {
        $data = parent::validationData();
        $segments = $this->segments();
        $id = $segments[count($segments)-1];
        $data['id'] = $id;
        return $data;
    }

    protected function getValidatorInstance()
    {
        $validatorInstance = parent::getValidatorInstance();
        $validatorInstance->addExtension('verifyEmail', function($attribute, $value, $parameters, $validator) {
            $validatorData = $validator->getData();
            return Admin::verifyUpdateAdminUserEmail($value,$validatorData['id']);
        });
        $validatorInstance->addExtension('verifyId', function($attribute, $value, $parameters, $validator) {
            return Admin::verifyAdminUserId($value);
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
            'id'         => 'verify_id',
            'email'      => 'verify_email',
            'password'   => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => trans('adminRequest.emailError'),
            'password.required'     => trans('adminRequest.passNull'),    
            'password.string'       => trans('adminRequest.passString'),
            'password.max'          => trans('adminRequest.passLength'),
        ];
    }

}
