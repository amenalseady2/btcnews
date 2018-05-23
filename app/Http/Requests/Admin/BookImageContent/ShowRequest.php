<?php

namespace App\Http\Requests\Admin\BookImageContent;
use Illuminate\Foundation\Http\FormRequest;
use Book;   
class ShowRequest extends FormRequest
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
        $validatorInstance->addExtension('verifyBookId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookId($value);
        });

        $validatorInstance->addExtension('verifyBookImageFileType', function($attribute, $value, $parameters, $validator) {
            $book = Book::getBookById($value);
            $bookFileTypes = Book::getBookFileTypes();
            if($book->file_type == $bookFileTypes['image'])
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
            'id' => 'required|verifyBookId|verifyBookImageFileType',
        ];
    }

    public function messages()
    {
        return [
            'id.required'                    => trans('bookRequest.bookIdNotice'),  
            'id.verify_book_id'              => trans('bookRequest.bookIdNotice'), 
            'id.verify_book_image_file_type' => trans('bookRequest.bookIdNotice'), 

        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back();
    }
}
