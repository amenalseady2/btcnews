<?php 
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Contracts\OutputServiceInterface;

class Output extends Facade {

    protected static function getFacadeAccessor() { return OutputServiceInterface::class; }
    
}
