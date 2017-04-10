<?php

namespace App\Http\Middleware;

use Closure;

class Auth
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
        return $response;
    }

}