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
        $path = trim($request->path(), '/');

        // Check if there is a redirect for this path
        // Use cache to prevent DB hit on every request
        $redirect = Cache::remember("redirect_{$path}", 3600, function () use ($path) {
            $fromCol = Redirect::getFromColumn();

            // Try matching with both leading slash and without
            return Redirect::where(function ($query) use ($fromCol, $path) {
                $query->where($fromCol, $path)
                    ->orWhere($fromCol, '/' . $path);
            })
                ->where('is_active', true)
                ->first();
        });

        if ($redirect) {
            // Increment hit count (optional but helpful for debugging)
            try {
                $redirect->increment('hit_count');
            } catch (\Throwable $e) {
                // Ignore errors here to not break the redirect itself
            }

            return redirect($redirect->to_url, $redirect->status_code);
        }

        return $next($request);
    }
}
