<?php

namespace App\Http\Middleware;

use App\Models\BigProject;
use App\Models\Project;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role == "super"){
            if ($request->user()->role != 2)
                return redirect()->back()->with('error', "You have no permission.");
        }
        return $next($request);
    }
}
