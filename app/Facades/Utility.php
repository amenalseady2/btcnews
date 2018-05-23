<?php 
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Contracts\UtilityServiceInterface;

class Utility extends Facade {

    protected static function getFacadeAccessor() { return UtilityServiceInterface::class; }
    
}
