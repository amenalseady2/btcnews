<?php 
namespace App\Modules\User;
use Illuminate\Support\ServiceProvider;
use App\Modules\User\Repositories\Contracts\UserReadbooksRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserReadbooksRepository;
use App\Modules\User\Repositories\Contracts\UserLevelRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserLevelRepository;
use App\Modules\User\Repositories\Contracts\UserInfoRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserInfoRepository;
use App\Modules\User\Repositories\Contracts\UserCoinLogRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserCoinLogRepository;
use App\Modules\User\Repositories\Contracts\UserCenterRepositoryInterface;
use App\Modules\User\Repositories\Eloquents\UserCenterRepository;
use App\Modules\User\Services\UserServiceInterface;
use App\Modules\User\Services\UserService;

class UserModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(UserCoinLogRepositoryInterface::class, UserCoinLogRepository::class);
		app()->bind(UserReadbooksRepositoryInterface::class, UserReadbooksRepository::class);
		app()->bind(UserLevelRepositoryInterface::class, UserLevelRepository::class);
		app()->bind(UserInfoRepositoryInterface::class, UserInfoRepository::class);
		app()->bind(UserServiceInterface::class, UserService::class);
	}

}
