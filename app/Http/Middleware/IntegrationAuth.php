<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IntegrationAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if ($request->has('api_id')){
            $user = User::where('api_id',$request->get('api_id'))->first();

            if ($user){

                $request->client = $user;

                return $next($request);
            }
            else{
                return response()->json(['message'=>'invalid API ID','error'=>true],400);
            }
        }else{
            return response()->json(['message'=>'invalid API ID','error'=>true],400);
        }
    }
}
