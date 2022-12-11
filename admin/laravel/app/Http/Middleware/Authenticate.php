<?php

namespace App\Http\Middleware;

use App\Libraries\Repositories\GeneralRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            $user = $request->session()->get('user_id');
            /*if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }*/
            if($user>0){
                $licencia_id = $request->session()->get('licencia_id');
                GeneralRepository::setConnection($licencia_id);
                Auth::loginUsingId($user);
                return $next($request);
            }
            else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
