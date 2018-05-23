<?php 
namespace App\Presenters\Eloquent;
use App\Presenters\Contracts\ConsoleSidebarPersenterInterface;
use Request;
use Route;

class ConsoleSidebarPersenter implements ConsoleSidebarPersenterInterface
{  
	public function getPlate()
	{
		$routeInfo = Route::currentRouteName();
		$routeInfoArr = explode(".", $routeInfo);
		return $routeInfoArr[0];
	}

	public function getSubject()
	{
		$routeInfo = Route::currentRouteName(); 
		$routeInfoArr = explode(".", $routeInfo);
		return $routeInfoArr[1];
	}

	public function getRouteName()
	{
		return Route::currentRouteName(); 
	}

	public function getModuleName()
	{
		$route = Route::current();
		$uri = $route->uri();
		$uriInfos = explode('/', $uri);
		return $uriInfos[1];
	}

	public function getPageMark()
	{
		return $this->getModuleName().'.'.$this->getRouteName();
	}
}