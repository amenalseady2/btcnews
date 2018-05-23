<?php 
namespace App\Modules\Admin\Services;
use App\Modules\Admin\Services\AdminServiceInterface;
use App\Modules\Admin\Repositories\Contracts\AdminUserRepositoryInterface;
use App\Exceptions\ServiceException;
use Validator;
use Session;

class AdminService implements AdminServiceInterface{

    const ADMIN_SESSION_KEY = 'Admin_Session_User';
    const ADMIN_LOGINTIME   = 'Admin_Session_User_logintime';
    private $adminUserRepository;
    
    public function __construct(AdminUserRepositoryInterface $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    public function getSessionUserEmail()
    {
        $adminUser = Session::get(self::ADMIN_SESSION_KEY);
        return $adminUser->email;
    }

    public function verifyStoreAdminUserEmail($email)
    {
        $rules = [
            'email'    => 'required|email|max:100|unique:admin_users,email,NULL,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['email'=>$email], $rules);
        return $validator->passes();
    }

    public function verifyUpdateAdminUserEmail($email,$id)
    {
        $rules = [
            'email'    => 'required|email|max:100|unique:admin_users,email,'.$id.',id,deleted_at,NULL',
        ];
        $validator = Validator::make(['email'=>$email], $rules);
        return $validator->passes();
    }

    public function verifyAdminUserId($id)
    {
        $rules = [
            'id' => 'required|integer|exists:admin_users,id,deleted_at,NULL',
        ];
        $validator = Validator::make(['id'=>$id], $rules);
        return $validator->passes();
    }

    public function storeAdminUser($email,$password)
    {
        $adminData =[
            'email'     => $email,
            'password'  => $password,
        ];

        $rules = [
            'email'    => 'required|email|verifyStoreAdminUserEmail',
            'password' => 'required|string|max:20',
        ];

        Validator::extend('verifyStoreAdminUserEmail', function($attribute, $value, $parameters, $validator) {
            return $this->verifyStoreAdminUserEmail($value);
        });

        $validator = Validator::make($adminData, $rules);
        if ($validator->passes()){

            $adminData['password'] = md5($adminData['password']); 
            $admin = $this->adminUserRepository->store($adminData);
            return $admin;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function updateAdminUser($id,$email,$password)
    {
        $adminData =[
            'email'     => $email,
            'password'  => $password,
        ];

        $rules = [
            'email'    => 'required',
            'password' => 'required|string|max:20',
        ];

        $validator = Validator::make($adminData, $rules);
        if ($validator->passes()){

            $adminData['password'] = md5($adminData['password']); 
            $admin = $this->adminUserRepository->updateById($id,$adminData);
            return $admin;

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getAdminUserPaginate(array $fileds=array(),$order='',$limit=20)
    {
        $adminUser = Session::get(self::ADMIN_SESSION_KEY);
        if($adminUser->email != 'admin@admin.com')
        {
            $fileds['id'] = $adminUser->id;
        }
        $getAdminData = [];
        $getAdminData['order'] = $order;
        $getAdminData += $fileds;
        $validator = $this->adminUserRepository->getFilterValidator($getAdminData);
        $rules = $validator->getRules();
        $rules['order'][] = 'in:'.implode(',', $this->adminUserRepository->getOrderFields());
        $validator->setRules($rules);
        if ($validator->passes()){
            $adminUserPage = $this->adminUserRepository->paginate($fileds,[$order],$limit);
            return $adminUserPage;
        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function getAdminUserById($id)
    {
        $validator = $this->adminUserRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->adminUserRepository->getById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function destoryAdminUserById($id)
    {
        $validator = $this->adminUserRepository->getFilterValidator(['id'=>$id]);
        if($validator->passes()) {
            return $this->adminUserRepository->destoryById($id);
        }else{  
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function login($email,$password)
    {
        $adminData =[
            'email'     => $email,
            'password'  => $password,
        ];

        $rules = [
            'email'    => 'required|email|max:100',
            'password' => 'required|max:20',
        ];

        $validator = Validator::make($adminData, $rules);
        if ($validator->passes()){

            $password = md5($password); 
            $admin  = $this->adminUserRepository->getByEmailPassword($email,$password);
            if($admin){
                Session::put(self::ADMIN_SESSION_KEY,$admin);
                Session::put(self::ADMIN_LOGINTIME,time());
                return true;
            }else{
                return false;
            }

        }else{
            $messages = $validator->messages();
            throw new ServiceException($messages);
        }
    }

    public function admin()
    {
        return Session::get(self::ADMIN_SESSION_KEY);
    }

    public function check()
    {
        if(Session::get(self::ADMIN_SESSION_KEY)){
            if((time() - Session::get(self::ADMIN_LOGINTIME)) <= 36000 )
            {
                return true;
            }
            return false;
        }else{
            return false;
        }
    }

    public function loginOut()
    {
       session([self::ADMIN_SESSION_KEY => null]);
       session([self::ADMIN_LOGINTIME => null]);
       return true;
    }

}