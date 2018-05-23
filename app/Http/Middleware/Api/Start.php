<?php 
namespace App\Http\Middleware\Api;
use Request;
use Passport;
use Closure;
use Output;

class Start
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
        $request->startTime = microtime();
        return $next($request);
    }

}