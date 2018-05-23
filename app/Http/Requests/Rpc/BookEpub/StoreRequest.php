<?php
namespace App\Http\Requests\Rpc\BookEpub;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Book;
use Utility;
use Request;

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
        $validatorInstance->addExtension('verifyRootBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyRootBookCategoryId($value);
        });

        $validatorInstance->addExtension('verifySlaveRelationByBookCategoryIdAndRootBookCategoryId', function($attribute, $value, $parameters, $validator) {
            $validatorData = $validator->getData();
            return Book::verifySlaveRelationByBookCategoryIdAndRootBookCategoryId($value,$validatorData['frist_category_id']);
        });

        $validatorInstance->addExtension('verifyBookRecommend', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookRecommend($value);
        }); 

        $validatorInstance->addExtension('verifyBookStatus', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookStatus($value);
        });

        $validatorInstance->addExtension('verifyUniqueBookSourceTag', function($attribute, $value, $parameters, $validator) {
            return Book::verifyUniqueBookSourceTag($value);
        });

        $validatorInstance->addExtension('verifyBookEpubType', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookEpubType($value);
        });

        $validatorInstance->addExtension('verifyEpubSize', function($attribute, $value, $parameters, $validator) {
           
            $epubSize = Utility::getUrlHeaderSize($value);
            if($epubSize < 1024*10)
            {
                return false;
            }else{
                return true;
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
         'frist_category_id'     => 'required|integer|verifyRootBookCategoryId',
         'second_category_id'    => 'required|integer|verifySlaveRelationByBookCategoryIdAndRootBookCategoryId',
         'name'                  => 'required|string|max:180',
         'author'                => 'required|string|max:100',
         'image'                 => 'url|max:300',
         'description'           => 'string|max:2000',
         'pub_date'              => 'date_format:Y|before_or_equal:'.date('Y'),
         'recommend'             => 'verifyBookRecommend',
         'status'                => 'verifyBookStatus',
         'weight'                => 'integer|min:0|max:999999',
         'epub_url'              => 'required|url|verifyEpubSize|max:300',
         'epub_type'             => 'required|verifyBookEpubType',
         'source_tag'            => 'required|string|max:100',
        ];
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);   
    }
}
