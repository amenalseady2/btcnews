<?php

namespace App\Http\Requests\Admin\Book;
use Illuminate\Foundation\Http\FormRequest;
use Book;
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
        $validatorInstance->addExtension('verifyBookCategoryId', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookCategoryId($value);
        });

        $validatorInstance->addExtension('verifyBookFileType', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookFileType($value);
        });

        $validatorInstance->addExtension('verifyBookSourceType', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookSourceType($value);
        });

        $validatorInstance->addExtension('verifyBookRecommend', function($attribute, $value, $parameters, $validator) {
            return Book::verifyBookRecommend($value);
        }); 

        $validatorInstance->addExtension('verifyBookStatus', function($attribute, $value, $parameters, $validator) {
            
            $bookStatuses = Book::getBookStatus();
            if($value == $bookStatuses['off'])
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
         'frist_category_id'     => 'required|integer|verifyRootBookCategoryId',
         'second_category_id'    => 'required|integer|verifyBookCategoryId',
         'name'                  => 'required|string|max:180',
         'author'                => 'required|string|max:100',
         'image'                 => 'nullable|url|max:300',
         'description'           => 'required|string|max:2000',
         'pub_date'              => 'nullable|date_format:Y|before_or_equal:'.date('Y'),
         'file_type'             => 'required|verifyBookFileType',
         'source_type'           => 'required|verifyBookSourceType',
         'recommend'             => 'required|verifyBookRecommend',
         'status'                => 'required|verifyBookStatus',
         'weight'                => 'required|integer|min:0|max:999999',
         'price'                 => 'required|integer|min:0',   
        ];
    }

    public function messages()
    {
        return [
         'frist_category_id.required'                         => trans('bookRequest.firstClass'),    
         'frist_category_id.integer'                          => trans('bookRequest.firstClas'),
         'frist_category_id.verify_root_book_category_id'     => trans('bookRequest.firstClas'),
         'second_category_id.required'                        => trans('bookRequest.secondClass'),
         'second_category_id.integer'                         => trans('bookRequest.secondClass'),
         'second_category_id.verify_book_category_id'         => trans('bookRequest.secondClass'),
         'name.required'                                      => trans('bookRequest.bookName'),
         'name.string'                                        => trans('bookRequest.bookString'),
         'name.max'                                           => trans('bookRequest.bookLength'),
         'author.required'                                    => trans('bookRequest.auth'),
         'author.string'                                      => trans('bookRequest.authString'),
         'author.max'                                         => trans('bookRequest.authLength'),
         //'image.required'                                     => trans('bookRequest.bookImage'),
         'image.url'                                          => trans('bookRequest.bookUrl'),
         'image.max'                                          => trans('bookRequest.bookUrlLength'),
         'description.required'                               => trans('bookRequest.bookdescript'),
         'description.string'                                 => trans('bookRequest.descriptString'),
         'description.max'                                    => trans('bookRequest.descriptLength'),
         'pub_date.date_format'                               => trans('bookRequest.dateAbnormal'),
         'pub_date.before_or_equal'                           => trans('bookRequest.today'),
         'file_type.required'                                 => trans('bookRequest.bookType'),
         'file_type.verify_book_file_type'                    => trans('bookRequest.typeNotice'),
         'source_type.required'                               => trans('bookRequest.source'),
         'source_type.verify_book_source_type'                => trans('bookRequest.sourceNotice'),
         'recommend.required'                                 => trans('bookRequest.promotionstatus'),
         'recommend.verify_book_recommend'                    => trans('bookRequest.statusNotice'),
         'status.required'                                    => trans('bookRequest.publishDate'),
         'status.verify_book_status'                          => trans('bookRequest.storeStatus'),
         'weight.required'                                    => trans('bookRequest.downShelves'),
         'weight.integer'                                     => trans('bookRequest.weightNumber'),
         'weight.min'                                         => trans('bookRequest.weightGreater'),
         'weight.max'                                         => trans('bookRequest.weightMax'),
         'price.required'                                     => trans('bookRequest.priceRequired'),
         'price.integer'                                      => trans('bookRequest.priceInteger'),
         'price.min'                                          => trans('bookRequest.priceMin'),
        ];
    }

}
