<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Presenters\Contracts\ConsoleParameterPersenterInterface;
use App\Presenters\Eloquent\ConsoleParameterPersenter;

class ConsoleParameterPersenterProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(ConsoleParameterPersenterInterface::class, ConsoleParameterPersenter::class);	
	}

}
