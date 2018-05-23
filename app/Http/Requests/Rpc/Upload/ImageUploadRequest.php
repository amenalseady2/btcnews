<?php

namespace App\Http\Requests\Rpc\Upload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
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
            'imageUrl'          => 'required|url',
            'width'             => 'integer|min:1|max:9999',
            'height'            => 'integer|min:1|max:9999',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }
}
