<?php
namespace App\Modules\Passport\Repositories\Eloquents;
use App\Modules\Passport\Repositories\Contracts\UserPassportRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Passport\Models\UserPassport;
use App\Exceptions\RepositoryException;

class UserPassportRepository extends EloquentRepository implements UserPassportRepositoryInterface 
{    
    use OperateIdTrait;

    const DEFAULT_GOOGLE_ID = '';
    const DEFAULT_FACEBOOK_ID = '';
    const DEFAULT_TWITTER_ID = '';

    public function __construct()
    {
        $userPassportModel = UserPassport::getInstance();
        parent::__construct($userPassportModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','device_id','contain_device_id','google_id','facebook_id','twitter_id','ip','country','onesignal_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'device_id'     => 'required|string|max:100',
                'google_id'     => 'string|max:100',
                'facebook_id'   => 'string|max:100',
                'twitter_id'    => 'string|max:100',                
                'password'      => 'required|string|max:255',
                'api_token'     => 'required|string|max:100',
                'ip'            => 'max:30',
                'country'       => 'max:30',
                'onesignal_id'  => 'string|max:150',
            ],
            'UPDATE' => [
                'device_id'     => 'string|max:100',
                'google_id'     => 'string|max:100',
                'facebook_id'   => 'string|max:100',
                'twitter_id'    => 'string|max:100',               
                'password'      => 'string|max:255',
                'api_token'     => 'string|max:100',
                'onesignal_id'  => 'string|max:150',
            ],            
            'FILTERFIELD' => [
                'id'                => 'integer',
                'ids'               => 'array',
                'ids.*'             => 'integer',
                'device_id'         => 'string',
                'contain_device_id' => 'string',
                'google_id'         => 'string',
                'facebook_id'       => 'string',
                'twitter_id'        => 'string',
                'onesignal_id'      => 'string',
            ]
        ];
    }

    public function getDefaultGoogleId()
    {
        return self::DEFAULT_GOOGLE_ID;
    }

    public function getDefaultFacebookId()
    {
        return self::DEFAULT_FACEBOOK_ID;
    }

    public function getDefaultTwitterId()
    {
        return self::DEFAULT_TWITTER_ID;
    }

    public function getUserIdByField($field,$value)
    {
        $model = $this->model;
        return $model->where($field,'=',$value)->first();
    }
    public function setUserStatus($id,$val)
    {
        $model = $this->model;
        return $model->where('id',$id)->update(['status'=>$val]);
    }
}
