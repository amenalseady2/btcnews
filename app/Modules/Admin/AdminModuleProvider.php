<?php 
namespace App\Modules\Admin;
use Illuminate\Support\ServiceProvider;
use App\Modules\Admin\Repositories\Contracts\AdminUserRepositoryInterface;
use App\Modules\Admin\Repositories\Eloquents\AdminUserRepository;
use App\Modules\Admin\Services\AdminServiceInterface;
use App\Modules\Admin\Services\AdminService;

class AdminModuleProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		app()->bind(AdminUserRepositoryInterface::class, AdminUserRepository::class);
		app()->bind(AdminServiceInterface::class, AdminService::class);
	}

}
