<?php

namespace App\Http\Requests\Admin\Upload;
use Illuminate\Foundation\Http\FormRequest;
use Book;     
class TxtUploadRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uploadFile'        => 'required|file|mimes:txt',
        ];
    }

    public function messages()
    {
        return [
            'uploadFile.required'  => trans('uploadRequest.uploadFile'), 
            'uploadFile.file'      => trans('uploadRequest.uploadFileNotice'), 
            'uploadFile.mimes'     => trans('uploadRequest.uploadTxt'), 
        ];
    }
}
