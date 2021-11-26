<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (in_array($request->user()->level, $levels)) {
            return $next($request);
        }
        if (Auth::user()->level == "admin") {
            return redirect('/admin');
        } elseif (Auth::user()->level == "kepsek") {
            return redirect('/kepsek');
        } elseif (Auth::user()->level == "waka") {
            return redirect('/waka');
        }
        // kalo misal akses hal lain masuk 403
        abort(403);
    }
}
