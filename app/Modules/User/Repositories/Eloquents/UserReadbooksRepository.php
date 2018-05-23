<?php
namespace App\Modules\User\Repositories\Eloquents;
use App\Modules\User\Repositories\Contracts\UserReadbooksRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\User\Models\UserReadbooks;
use App\Exceptions\RepositoryException;

class UserReadbooksRepository extends EloquentRepository implements UserReadbooksRepositoryInterface 
{
    use OperateIdTrait;
    public function __construct()
    {
        $UserReadbooksModel = UserReadbooks::getInstance();
        parent::__construct($UserReadbooksModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','user_id','book_id'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
            ],
            'UPDATE' => [
                'readindex' => 'string|max:100',
            ],            
            'FILTERFIELD' => [
                'id'        => 'integer',
                'user_id'   => 'integer',
                'book_id'   => 'integer',
                'readindex' => 'string',
            ]
        ];
    }
}
