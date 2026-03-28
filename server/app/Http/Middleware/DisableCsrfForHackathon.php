<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableCsrfForHackathon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // For hackathon: disable CSRF verification temporarily
        // TODO: Re-enable CSRF protection before production deployment
        $request->headers->set('X-CSRF-TOKEN', 'disabled-for-hackathon');
        
        return $next($request);
    }
}
