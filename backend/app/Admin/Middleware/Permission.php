<?php

namespace App\Admin\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Permission
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
        $user = $request->user();

        $uri = substr($request->path(),3);

        $permit_uri = $user->getAllPermissions()->map(function ($permission){
            return $permission->uri;
        })->toArray();

        if(!in_array($uri,$permit_uri)){
            return apiReturn([],'Permission Denied',403);
        }

        return $next($request);
    }
}
