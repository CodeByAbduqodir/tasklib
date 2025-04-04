<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('AdminMiddleware: Checking user', [
            'user_id' => auth()->id(),
            'email' => auth()->user() ? auth()->user()->email : null,
            'is_admin' => auth()->user() ? auth()->user()->is_admin : null,
            'path' => $request->path(),
        ]);

        if (auth()->check() && auth()->user()->is_admin) {
            \Log::info('AdminMiddleware: User is admin, proceeding');
            return $next($request);
        }

        \Log::info('AdminMiddleware: User is not admin, aborting');
        abort(403, 'Unauthorized action.');
    }
}