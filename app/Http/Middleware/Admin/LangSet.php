<?php 
    
namespace App\Http\Middleware\Admin;

use Request;
use Closure;
use Session;
use App;

class LangSet
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
        $userLang = Session::get('userLang','cn');
        App::setLocale($userLang);
        return $next($request);  
    }

}