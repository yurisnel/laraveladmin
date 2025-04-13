<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->state == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', __('messages.account_disable'));
        }
        $route = $request->route()->getName();
        if (!Auth::user()->hasPermissionRouteName($route)) {
            return back()->with('error', __('messages.not_access'));
            //abort(403, __('messages.not_access'));
        }
        return $next($request);
    }
}
