<?php

namespace App\Http\Requests\Admin\Notify;
use Illuminate\Foundation\Http\FormRequest;
use Notify;
use Request;

class CenterStoreRequest extends FormRequest
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
        // $validatorInstance->addExtension('verifyRootNotifyCategoryId', function($attribute, $value, $parameters, $validator) {
        //     return Notify::verifyRootNotifyCategoryId($value);
        // });


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
            'type'               => 'required',
            'starttime'          => 'required',
            'endtime'            => 'required',
            'title'              => 'required|string',
            'content'            => 'required|string',      
        ];
    }

    public function messages()
    {
        return [
         'type.required'                               => trans('notify.messageTypeNotNull'),
         'starttime.required'                          => trans('notify.startimeNotNull'),
         'endtime.required'                            => trans('notify.endtimeNotNull'),
         'title.required'                              => trans('notify.titleNotNull'),
         'content.required'                            => trans('notify.contentNotNull'), 
        ];
    }

}
