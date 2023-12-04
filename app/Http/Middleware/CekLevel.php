<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next, ...$levels)
    // {
    //     if(in_array($request->user()->hakAkses, $levels)){
    //         return $next($request);
    //     }
    //     return abort(404);
    // }
    // Cek level middleware
    public function handle($request, Closure $next, $hakAkses)
    {
        $user = $request->user();

        if ($user && $user->hakAkses == $hakAkses) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
