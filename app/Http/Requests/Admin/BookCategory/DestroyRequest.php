<?php

namespace App\Http\Requests\Admin\BookCategory;
use Illuminate\Foundation\Http\FormRequest;
use Book;
class DestroyRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyDestoryBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyDestoryBookCategoryId($value);
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
            'id' => 'required|integer|verifyDestoryBookCategoryId',
        ];
    }

    public function messages()
    {
        return [
            'id.required'                        => trans('bookRequest.idNotice'),    
            'id.integer'                         => trans('bookRequest.idNotice'),
            'id.verify_destory_book_category_id' => trans('bookRequest.classNotDelete'),
        ];
    }

}
