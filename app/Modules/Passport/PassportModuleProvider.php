<?php 
namespace App\Modules\Passport;
use Illuminate\Support\ServiceProvider;
use App\Modules\Passport\Repositories\Contracts\UserPassportRepositoryInterface;
use App\Modules\Passport\Repositories\Eloquents\UserPassportRepository;
use App\Modules\Passport\Services\PassportServiceInterface;
use App\Modules\Passport\Services\PassportService;

class PassportModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(UserPassportRepositoryInterface::class, UserPassportRepository::class);
		app()->bind(PassportServiceInterface::class, PassportService::class);
	}

}
