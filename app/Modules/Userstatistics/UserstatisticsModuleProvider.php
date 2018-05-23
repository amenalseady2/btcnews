<?php 
namespace App\Modules\Userstatistics;
use Illuminate\Support\ServiceProvider;
use App\Modules\Userstatistics\Services\UserstatisticsServiceInterface;
use App\Modules\Userstatistics\Services\UserstatisticsService;
use App\Modules\Userstatistics\Repositories\Contracts\UserstatisticsRepositoryInterface;
use App\Modules\Userstatistics\Repositories\Eloquents\UserstatisticsRepository;

class UserstatisticsModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(UserstatisticsServiceInterface::class, UserstatisticsService::class);
		app()->bind(UserstatisticsRepositoryInterface::class, UserstatisticsRepository::class);
	}

}
