<?php

namespace App\Http\Middleware;

use Closure;
/*use Illuminate\Http\Request;*/
use Illuminate\Support\Facades\Auth;

class Subscribed
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
        if (!Auth::check() || !Auth::user()->token) {
            return redirect()->route('home')->with('error_message', '有料会員のみアクセスできます。');
        }

        return $next($request);
    }
}
