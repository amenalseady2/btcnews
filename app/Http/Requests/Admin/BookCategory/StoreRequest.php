<?php

namespace App\Http\Requests\Admin\BookCategory;
use Illuminate\Foundation\Http\FormRequest;
use Book;
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
        $validatorInstance->addExtension('verifyRootBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyRootBookCategoryId($value);
        });
        $validatorInstance->addExtension('verifyStoreBookCategoryName', function($attribute, $value, $parameters, $validator) {
            return Book::verifyStoreBookCategoryName($value);
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
            'book_category_id'  => 'required|integer|verifyRootBookCategoryId',
            'name'              => 'required|string|max:100|verifyStoreBookCategoryName',
            'weight'            => 'required|integer|min:0|max:99',
        ];
    }

    public function messages()
    {
        return [
            'book_category_id.required'                         => trans('bookRequest.fatherClassNotice'),   
            'book_category_id.integer'                          => trans('bookRequest.fatherClassNotice'),   
            'book_category_id.verify_root_book_category_id'     => trans('bookRequest.fatherClassNotice'),   
            'name.required'                                     => trans('bookRequest.className'),      
            'name.string'                                       => trans('bookRequest.classNameString'),   
            'name.max'                                          => trans('bookRequest.classNameLength'),
            'name.verify_store_book_category_name'              => trans('bookRequest.alreadyExists'),
            'weight.required'                                   => trans('bookRequest.classWeight'),
            'weight.integer'                                    => trans('bookRequest.classNumber'),
            'weight.min'                                        => trans('bookRequest.classWeightGreater'),
            'weight.max'                                        => trans('bookRequest.classWeightMax'),
        ];
    }

}
