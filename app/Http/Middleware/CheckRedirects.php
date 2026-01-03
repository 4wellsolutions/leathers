<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;

class CheckRedirects
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Check if there is a redirect for this path
        // Use cache to prevent DB hit on every request
        // Cache key includes 'redirect_' and the path
        $redirect = Cache::remember("redirect_{$path}", 3600, function () use ($path) {
            return Redirect::where('old_url', $path)
                ->where('is_active', true)
                ->first();
        });

        if ($redirect) {
            return redirect($redirect->new_url, $redirect->status_code);
        }

        return $next($request);
    }
}
