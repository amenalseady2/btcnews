<?php 
namespace App\Providers;

use App\Services\Contracts\UtilityServiceInterface;
use App\Services\Eloquent\UtilityService;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(UtilityServiceInterface::class, UtilityService::class);
	}

}
