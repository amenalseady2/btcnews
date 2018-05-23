<?php
namespace App\Modules\User\Repositories\Eloquents;
use App\Modules\User\Repositories\Contracts\UserCoinLogRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\User\Models\UserCoinLog;
use App\Exceptions\RepositoryException;

class UserCoinLogRepository extends EloquentRepository implements UserCoinLogRepositoryInterface 
{    
    use OperateIdTrait;
    const TYPES = [
        'sign'                  => 1,
        'share'                 => 2,
        'invite'                => 3,
        'beInvited'             => 4,
        'mark'                  => 5,
        'launch'                => 6,
        'collection'            => 7,
        'readFiveMinute'        => 8,
        'readTenMinute'         => 9,
        'readHalfhour'          => 10,
        'firstAccountLogin'     => 11,
        'completionUserinfo'    => 12,
        'payOrder'              => 13,
    ];

    const DEFAULT_EXTEND = [];
    public function __construct()
    {
        $userCoinLogModel = UserCoinLog::getInstance();
        parent::__construct($userCoinLogModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','user_passport_id','type','types','created_at_gte','created_at_lte'];
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
                'coin'              => 'required|integer',
                'type'              => 'required|integer|in:'.implode(',', self::TYPES),
                'extend'            => 'array'
            ],
            'UPDATE' => [
                'user_passport_id'  => 'integer',
                'coin'              => 'integer',
                'type'              => 'integer|in:'.implode(',', self::TYPES),
                'extend'            => 'array'
            ],            
            'FILTERFIELD' => [
                'id'                => 'integer',
                'ids'               => 'array',
                'ids.*'             => 'integer',
                'user_passport_id'  => 'integer',
                'type'              => 'integer',
                'types'             => 'array',
                'types.*'           => 'integer',
                'created_at_gte'    => 'date',
                'created_at_lte'    => 'date',
            ]
        ];
    }

    public function getTypes()
    {
        return self::TYPES;
    }

    public function getDefaultExtend()
    {
        return self::DEFAULT_EXTEND;
    }

}
