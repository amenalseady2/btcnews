<?php 
namespace App\Http\Middleware\Api;
use Request;
use Passport;
use Closure;
use Output;

class VerifyApiToken
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
        $apiToken = Request::Input('api_token');
        $tag = Passport::check();

        if($tag)
        {
            return $next($request);
        }else{
            return Output::needLogin();
        }
    }

}