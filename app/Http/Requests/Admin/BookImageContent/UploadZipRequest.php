<?php

namespace App\Http\Requests\Admin\BookImageContent;
use Illuminate\Foundation\Http\FormRequest;
class UploadZipRequest extends FormRequest
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
            // 'book_id' => 'required|verifyBookId|verifyBookImageFileType',
            'zip'     => 'required|mimes:zip'  
        ];
    }

    public function messages()
    {
        return [
            'book_id.required'                    => trans('bookRequest.bookIdNotice'),   
            'book_id.verify_book_id'              => trans('bookRequest.bookIdNotice'), 
            'book_id.verify_book_image_file_type' => trans('bookRequest.bookIdNotice'), 
            'zip.required'                        => trans('bookRequest.uploadZip'),  
            'zip.mimes'                           => trans('bookRequest.uploadZip'), 
        ];
    }
}
