<?php
namespace App\Http\Requests\Api\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Book;

class BookEpubContentRequest extends FormRequest
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
        $data['book_id'] = $id;
        return $data;
    }    

    protected function getValidatorInstance()
    {
        $validatorInstance = parent::getValidatorInstance();
        $validatorInstance->addExtension('verifyBookId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookId($value);
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
            'book_id' => 'required|integer|verifyBookId',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }

}