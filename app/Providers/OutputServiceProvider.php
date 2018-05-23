<?php 
namespace App\Providers;

use App\Services\Contracts\OutputServiceInterface;
use App\Services\Eloquent\OutputService;
use Illuminate\Support\ServiceProvider;

class OutputServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(OutputServiceInterface::class, OutputService::class);
	}

}
