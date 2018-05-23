<?php 
    
namespace App\Http\Middleware\Admin;

use Request;
use Admin;
use Closure;

class VerifyAdminUser
{

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Admin::check())
        {
            return $next($request);
        }else{
            return redirect('admin/index');
        }
    }

}