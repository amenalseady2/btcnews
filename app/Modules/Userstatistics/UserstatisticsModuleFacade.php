<?php 
namespace App\Modules\Userstatistics;
use Illuminate\Support\Facades\Facade;
use App\Modules\Userstatistics\Services\UserstatisticsServiceInterface;

class UserstatisticsModuleFacade extends Facade {

    protected static function getFacadeAccessor() { return UserstatisticsServiceInterface::class; }
    
}
