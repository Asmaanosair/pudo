<?php

namespace App\Http\Middleware;

use App\Api_key;
use Closure;

class ApiKey
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
        $auth= $request->header('X-Authorization');
        $key=\Ejarnutowski\LaravelApiKey\Models\ApiKey::where('key',$auth)->first();
        if(empty($key)){
            return response()->json(['message' => 'Unauthenticated. dispatcher role required'], 401);
        }
        return $next($request);
    }
}
