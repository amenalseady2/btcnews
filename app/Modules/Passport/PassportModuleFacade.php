<?php 
namespace App\Modules\Passport;
use Illuminate\Support\Facades\Facade;
use App\Modules\Passport\Services\PassportServiceInterface;

class PassportModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return PassportServiceInterface::class; }
    
}