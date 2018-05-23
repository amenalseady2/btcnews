<?php
namespace App\Modules\Admin\Repositories\Eloquents;
use App\Modules\Admin\Repositories\Contracts\AdminUserRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Repositories\OperateIdTrait;
use App\Modules\Admin\Models\AdminUser;
use App\Exceptions\RepositoryException;

class AdminUserRepository extends EloquentRepository implements AdminUserRepositoryInterface 
{    
    use OperateIdTrait;

    public function __construct()
    {
        $adminUserModel = AdminUser::getInstance();
        parent::__construct($adminUserModel);
    }

    protected function initFilterField()
    {
        $this->filterFields = ['id','ids','email','password'];
    }

    protected function initOrderField()
    {
        $this->orderFields = ['id_asc', 'id_desc'];
    }

    protected function initValidatorRules()
    {
        $this->rules = [
            'STORE' => [
                'email'     => 'required|email|max:100',
                'password'  => 'required|max:32',
            ],
            'UPDATE' => [
                'email'     => 'required|email|max:100',
                'password'  => 'required|max:32',
            ],            
            'FILTERFIELD' => [
                'id'        => 'integer',
                'ids'       => 'array',
                'ids.*'     => 'integer',
                'email'     => 'email',
                'password'  => 'string',                
            ]
        ];
    }

    public function getByEmailPassword($email,$password)
    {
        $fileds = [];
        $fileds['email'] = $email;
        $fileds['password'] = $password;
        $adminUser = $this->getOne($fileds);
        return $adminUser;
    }

    public function getByIdEmail($id,$email)
    {
        $fileds = [];
        $fileds['id'] = $id;
        $fileds['email'] = $email;
        $adminUser = $this->getOne($fileds);
        return $adminUser;
    }

    public function getByEmail($email)
    {
        $fileds = [];
        $fileds['email'] = $email;
        $admins = $this->getOne($fileds);
        return $admins;
    } 

}
