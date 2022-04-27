<?php

namespace App\Http\Middleware;

use App\Fleet;
use Closure;

class JwtAuthFleet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    public function handle($request, Closure $next)
    {
        $auth= str_replace('Bearer ','',$request->header('Authorization'));
        if(isset($auth) && $auth != null){
            if(!auth('fleet')->user()){
                return response()->json(['message' => 'Error Token'],401);
            }
        } else {
            return response()->json(['message' => 'Please Enter Auth Token in header' ],403);

        }


        return $next($request);
    }
}
