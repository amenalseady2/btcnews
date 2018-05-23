<?php

namespace App\Http\Requests\Admin\BookImageContent;
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
        $validatorInstance->addExtension('verifyBookId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookId($value);
        });
        $validatorInstance->addExtension('verifyBookImageContentId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookImageContentId($value);
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
        $validatorInstance->addExtension('verifyBookImageContentPageWithBookIdIgnoreId', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            return Book::verifyBookImageContentPageWithBookIdIgnoreId($data['id'],$data['book_id'],$data['page']);
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
            'id'        => 'required|verifyBookImageContentId',
            'book_id'   => 'required|verifyBookId|verifyBookImageFileType', 
            'page'      => 'required|integer|verifyBookImageContentPageWithBookIdIgnoreId',
            'url'       => 'required|url|string|max:300',
        ];
    }

    public function messages()
    {
        return [                                                               
            'id.required'                                                   => trans('bookRequest.idNotice'),     
            'id.verify_book_image_content_id'                               => trans('bookRequest.idNotice'), 
            'book_id.required'                                              => trans('bookRequest.bookIdNotice'),    
            'book_id.verify_book_id'                                        => trans('bookRequest.bookIdNotice'), 
            'book_id.verify_book_image_file_type'                           => trans('bookRequest.bookIdNotice'), 
            'page.required'                                                 => trans('bookRequest.bookPage'),
            'page.integer'                                                  => trans('bookRequest.pageNum'),
            'page.verify_book_image_content_page_with_book_id_ignore_id'    => trans('bookRequest.existence'),
            'url.required'                                                  => trans('bookRequest.uploadReadImg'),
            'url.url'                                                       => trans('bookRequest.readNotice'),
            'url.string'                                                    => trans('bookRequest.readNotice'),
            'url.max'                                                       => trans('bookRequest.readLength'),
        ];
    }

}
