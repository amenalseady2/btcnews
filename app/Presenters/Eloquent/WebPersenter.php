<?php 
namespace App\Presenters\Eloquent;
use App\Presenters\Contracts\WebPersenterInterface;
use Request;
use Route;

class WebPersenter implements WebPersenterInterface
{  
	public function getHeadNavbarActive()
	{
		$route = Route::current();
		$parameters = $route->parameters();
		$uri = $route->uri();
		$uriArray = array_filter(explode("/", $uri));

		if(isset($uriArray[0]) && $uriArray[0] == 'forum'  )
		{
			if(isset($uriArray[0]) && $uriArray[0] == 'forum' && isset($uriArray[1]) && $uriArray[1] == 'category' &&  isset($parameters['id']) &&   $parameters['id'] == '1'  )
			{
				return 'technology';
			}elseif(isset($uriArray[0]) && $uriArray[0] == 'forum' && isset($uriArray[1]) && $uriArray[1] == 'category' &&  isset($parameters['id']) &&   $parameters['id'] == '2'  ){
				return 'specialColumn';
			}else{
				return 'forum';
			}
		}

		if(isset($uriArray[0]) && $uriArray[0] == 'article'  )
		{
			if(isset($uriArray[0]) && $uriArray[0] == 'article' && isset($uriArray[1]) && $uriArray[1] == 'category' &&  isset($parameters['id']) &&   $parameters['id'] == '1'  )
			{
				return 'pioneer';
			}else{
				return 'article';
			}
		}

		return '';
	}

}