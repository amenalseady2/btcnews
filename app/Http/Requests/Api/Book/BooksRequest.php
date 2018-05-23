<?php

namespace App\Http\Requests\Api\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Book;

class BooksRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookCategoryId($value);
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
            'ids'                   => 'array',
            'ids.*'                 => 'integer|min:0',
            'tag_ids'               => 'array',
            'tag_ids.*'             => 'integer|min:0',
            'name'                  => 'string|min:0',
            'author'                => 'string|min:0',
            'author_equal'          => 'string|min:0',
            'frist_category_id'     => 'integer|min:0',
            'second_category_id'    => 'integer|min:0',
            'order'                 => 'in:id_asc,id_desc,weight_asc,weight_desc,collection_number_asc,collection_number_desc,id_rand',
            'offset'                => 'integer|min:0',
            'limit'                 => 'integer|min:0',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }

}