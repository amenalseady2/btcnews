<?php
namespace App\Modules\User\Repositories\Eloquents;
use App\Modules\User\Repositories\Contracts\UserLevelRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\User\Models\UserSetlevel;
use App\Exceptions\RepositoryException;

class UserLevelRepository extends EloquentRepository implements UserLevelRepositoryInterface 
{
    use OperateIdTrait;
    public function __construct()
    {
        $UserSetlevel = UserSetlevel::getInstance();
        parent::__construct($UserSetlevel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','level','name','experience'];
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
                'name' => 'string|max:50',
            ],            
            'FILTERFIELD' => [
                'id'        => 'integer',
                'level'   => 'integer',
                'experience'   => 'integer',
                'name' => 'string',
            ]
        ];
    }

    public function getByField($field,$value)
    {
        $model = $this->model;
        return $model->where($field,'=',$value)->first();
    }

    public function storeUserLevel($data)
    {
        $model = $this->model;
        $model->level      = $data['level'];
        $model->name       = $data['name'];
        $model->experience = $data['experience'];
        return $model->save();
    }
    
    public function getAll()
    {
        $model = $this->model;
        return $model->orderBy('level','desc')->get();
    }
}
