<?php
namespace App\Http\Requests\Api\Passport;
use Illuminate\Foundation\Http\FormRequest;
use Passport;

class BindGoogleIdByDeviceIdRequest extends FormRequest
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
        $validatorInstance->addExtension('uniqueGoogleId', function($attribute, $value, $parameters, $validator) {
            
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
            'device_id'   => 'required|string|max:255|verifyDeviceId',
            'google_id'   => 'required|string|max:100|uniqueGoogleId',
        ];
    }

}
