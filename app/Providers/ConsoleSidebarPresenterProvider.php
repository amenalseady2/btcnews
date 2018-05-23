<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Presenters\Contracts\ConsoleSidebarPersenterInterface;
use App\Presenters\Eloquent\ConsoleSidebarPersenter;

class ConsoleSidebarPresenterProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(ConsoleSidebarPersenterInterface::class, ConsoleSidebarPersenter::class);	
	}

}
