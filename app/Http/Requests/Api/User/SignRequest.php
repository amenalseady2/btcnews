<?php

namespace App\Http\Requests\Api\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Passport;
use User;

class SignRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyCoinViaSign', function($attribute, $value, $parameters, $validator) {
            $passport = Passport::user();
            return User::verifyCoinViaSign($passport->id);
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
            'api_token' => 'required|verifyCoinViaSign',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }

}