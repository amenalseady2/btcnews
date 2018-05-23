<?php

namespace App\Http\Requests\Admin\BookImageContent;
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

        $validatorInstance->addExtension('verifyBookImageContentPageWithBookId', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return Book::verifyBookImageContentPageWithBookId($data['book_id'],$data['page']);
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
            'book_id'   => 'required|verifyBookId|verifyBookImageFileType', 
            'page'      => 'required|integer|verifyBookImageContentPageWithBookId',
            'url'       => 'required|url|string|max:300',
        ];
    }

    public function messages()
    {
        return [
            'book_id.required'                                  => trans('bookRequest.bookIdNotice'),    
            'book_id.verify_book_id'                            => trans('bookRequest.bookIdNotice'), 
            'book_id.verify_book_image_file_type'               => trans('bookRequest.bookIdNotice'), 	
            'page.required'                                     => trans('bookRequest.bookPage'),
            'page.integer'                                      => trans('bookRequest.pageNum'),
            'page.verify_book_image_content_page_with_book_id'  => trans('bookRequest.existence'),
            'url.required'                                      => trans('bookRequest.uploadReadImg'),
            'url.url'                                           => trans('bookRequest.readNotice'),
            'url.string'                                        => trans('bookRequest.readNotice'),
            'url.max'                                           => trans('bookRequest.readLength'),
        ];
    }

}
