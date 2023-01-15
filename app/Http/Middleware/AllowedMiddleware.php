<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->allowed != 1){
            if ($user->is_new == 0){
                $msg = "<p>Registered Successfully.</p><p>Please wait until you are allowed by admin.</p>";
                $user->is_new = 1;
                $user->save();
            }else
                $msg = "<p>You are not allowed by admin.</p><p>Please wait until you are allowed by admin.</p>";

            auth()->logout();
            return redirect()->back()->with('error', $msg);
        }
        return $next($request);
    }
}
