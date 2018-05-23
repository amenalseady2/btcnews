<?php 
namespace App\Http\Middleware\Rpc;
use Request;
use Closure;
use Output;

class VerifySecret
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
        $secret = Request::input('secret');
        $envSectrt = env('RPC_SECRET');

        if($envSectrt && $secret && $secret == $envSectrt)
        {
            return $next($request);
        }else{
            return Output::needSecret();
        }
    }

}