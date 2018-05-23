<?php

namespace App\Http\Requests\Admin\BookCategory;
use Illuminate\Foundation\Http\FormRequest;
use Book;
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
        $validatorInstance->addExtension('verifyBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookCategoryId($value);
        });
        $validatorInstance->addExtension('verifyRootBookCategoryId', function($attribute, $value, $parameters, $validator) {
            $validatorData = $validator->getData();
            if($validatorData['id'] == $value)
            {
                return false;
            }else{
                return Book::verifyRootBookCategoryId($value);
            }
        });        
        $validatorInstance->addExtension('verifyUpdateBookCategoryName', function($attribute, $value, $parameters, $validator) {
            $validatorData = $validator->getData();
            return Book::verifyUpdateBookCategoryName($value,$validatorData['id']);
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
            'id'                    => 'required|integer|verifyBookCategoryId',
            'book_category_id'      => 'required|integer|verifyRootBookCategoryId',
            'name'                  => 'required|string|max:100|verifyUpdateBookCategoryName',
            'weight'                => 'required|integer|min:0|max:99',
        ];
    }

    public function messages()
    {
        return [
            'id.required'                                   => trans('bookRequest.idNotice'),  
            'id.integer'                                    => trans('bookRequest.idNotice'), 
            'id.verify_book_category_id'                    => trans('bookRequest.idNotice'), 
            'book_category_id.required'                     => trans('bookRequest.fatherClassNotice'),    
            'book_category_id.integer'                      => trans('bookRequest.fatherClassNotice'),
            'book_category_id.verify_root_book_category_id' => trans('bookRequest.fatherClassNotice'),
            'name.required'                                 => trans('bookRequest.className'),    
            'name.string'                                   => trans('bookRequest.classNameString'),
            'name.max'                                      => trans('bookRequest.classNameLength'),
            'name.verify_update_book_category_name'         => trans('bookRequest.alreadyExists'),
            'weight.required'                               => trans('bookRequest.classWeight'),
            'weight.integer'                                => trans('bookRequest.classNumber'),
            'weight.min'                                    => trans('bookRequest.classWeightGreater'),
            'weight.max'                                    => trans('bookRequest.classWeightMax'),
        ];
    }

}
