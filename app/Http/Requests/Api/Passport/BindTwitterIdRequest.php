<?php
namespace App\Http\Requests\Api\Passport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Passport;
use Output;

class BindTwitterIdByDeviceIdRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyDeviceId', function($attribute, $value, $parameters, $validator) {
            return Passport::verifyDeviceId($value);
        });
        $validatorInstance->addExtension('uniqueTwitterId', function($attribute, $value, $parameters, $validator) {
            
              $data = $validator->getData();
              $passport = Passport::getPassportByDeviceId($data['device_id']);
              if($passport)
              {
                return Passport::uniqueTwitterId($value,$passport->id);
              }else{
                return false;
              }
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
            'device_id'    => 'required|string|max:255|verifyDeviceId',
            'twitter_id'   => 'required|string|max:100|uniqueTwitterId',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }
}
