<?php
namespace App\Modules\User\Repositories\Eloquents;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\User\Models\UserInfo;
use App\Exceptions\RepositoryException;

class UserInfoRepository extends EloquentRepository implements UserInfoRepositoryInterface 
{
    use OperateIdTrait; 
    const DEFAULT_COIN = 0;
    const DEFAULT_EXPERIENCE = 0;

    public function __construct()
    {
        $userInfoModel = UserInfo::getInstance();
        parent::__construct($userInfoModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','likebook','user_passport_id','user_passport_ids','created_at_gte','created_at_lte'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'user_passport_id'  => 'required|integer',
                'nickname'          => 'string|max:30',
                'coin'              => 'required|integer',
                'sex'               => 'integer',
            ],
            'UPDATE' => [
                'user_passport_id'  => 'integer',
                'nickname'          => 'string|max:30',
                'coin'              => 'integer',
                'sex'               => 'integer',
            ],            
            'FILTERFIELD' => [
                'id'                    => 'integer',
                'ids'                   => 'array',
                'id.*'                  => 'integer',
                'user_passport_id'      => 'integer',
                'user_passport_ids'     => 'array',
                'user_passport_ids.*'   => 'integer',
                'created_at_gte'        => 'date_format:Y-m-d H:i:s',
                'created_at_lte'        => 'date_format:Y-m-d H:i:s',
            ]
        ];
    }

    public function getDefaultCoin()
    {
        return self::DEFAULT_COIN;
    }

    public function getDefaultExperience()
    {
        return self::DEFAULT_EXPERIENCE;
    }

    public function getByUserPassportId($userPassportId)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        return $this->getOne($fileds);
    }

    public function getByUserPassportIds(array $userPassportIds)
    {
        $fileds = [];
        $fileds['user_passport_ids'] = $userPassportIds;
        return $this->get($fileds);
    }

    public function incrByCoinByUserPassportId($userPassportId,$coin)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $userInfoModel = $this->filter($fileds);
        return $userInfoModel->increment('coin',$coin);
    }

    public function decrByCoinByUserPassportId($userPassportId,$coin)
    {
        $fileds = [];
        $fileds['user_passport_id'] = $userPassportId;
        $userInfoModel = $this->filter($fileds);
        return $userInfoModel->decrement('coin',$coin);
    }

    public function getByField($field,$value)
    {
        $model = $this->model;
        return $model->where($field,'=',$value)->first();
    }

}
