<?php

namespace App\Http\Requests\Admin\Upload;
use Illuminate\Foundation\Http\FormRequest;
use Book; 
class ImageUploadRequest extends FormRequest
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
            'uploadFile'        => 'required|file|image',
            'width'             => 'integer|min:0|max:9999',
            'height'            => 'integer|min:0|max:9999',
        ];
    }

    public function messages()
    {
        return [
            'uploadFile.required'  => trans('uploadRequest.uploadFile'),  
            'uploadFile.file'      => trans('uploadRequest.uploadFileNotice'),
            'uploadFile.image'     => trans('uploadRequest.uploadImg'), 
            'width.integer'        => trans('uploadRequest.widthInteger'),    
            'width.min'            => trans('uploadRequest.widthMin'),
            'width.max'            => trans('uploadRequest.widthMax'),
            'height.integer'       => trans('uploadRequest.heightInteger'),
            'height.min'           => trans('uploadRequest.heightMin'),
            'height.max'           => trans('uploadRequest.heightMax'),
        ];
    }
}
