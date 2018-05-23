<?php 
namespace App\Http\Middleware\Api;
use Request;
use Passport;
use Closure;
use Output;
use Log;

class End
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
        $response = $next($request);
        $request->endTime = microtime();
        $starttime = explode(' ',$request->startTime);
        $endtime = explode(' ',$request->endTime);
        $rumTime = round(  ( ($endtime[0]+$endtime[1])-($starttime[0]+$starttime[1]) ) ,5);

        $logData = [];
        $logData['startTime'] = $request->startTime;
        $logData['endTime'] = $request->endTime;
        $logData['rumTime'] = $rumTime;
        $logData['url'] = $request->fullUrl();
        Log::info(json_encode($logData));

        return $response;

    }

}