<?php 
namespace App\Modules\User;
use Illuminate\Support\Facades\Facade;
use App\Modules\User\Services\UserServiceInterface;

class UserModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return UserServiceInterface::class; }
    
}
