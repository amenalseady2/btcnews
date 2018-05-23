<?php
namespace App\Http\Requests\Api\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Book;

class GetEpubContentByBookIdsRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyBookIds', function($attribute, $value, $parameters, $validator) {
        
            $bookFileTypes = Book::getBookFileTypes();
            $fileds = [];
            $fileds['file_type'] = $bookFileTypes['epub'];
            $fileds['ids'] = $value;
            $bookCount = Book::getBookCount($fileds);
            if(count($value) == $bookCount)
            {
                return true;
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
            'book_ids'      => 'required|array|verifyBookIds',
            'book_ids.*'    => 'required|integer',            
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }

}