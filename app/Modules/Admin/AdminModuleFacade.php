<?php 
namespace App\Modules\Admin;
use Illuminate\Support\Facades\Facade;
use App\Modules\Admin\Services\AdminServiceInterface;

class AdminModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return AdminServiceInterface::class; }
    
}
