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
            $result = Redirect::where(function ($query) use ($fromCol, $path) {
                $query->where($fromCol, $path)
                    ->orWhere($fromCol, '/' . $path)
                    ->orWhere($fromCol, $path . '/')
                    ->orWhere($fromCol, '/' . $path . '/');
            })
                ->where('is_active', true)
                ->first();

            // Return a sentinel value when no redirect found so null is not cached ambiguously
            return $result ?? '__none__';
        });

        if ($redirect && $redirect !== '__none__') {
            // Increment hit count (optional but helpful for debugging)
            try {
                $redirect->increment('hit_count');
            } catch (\Throwable $e) {
                // Ignore errors here to not break the redirect itself
            }

            $toCol = Redirect::getToColumn();
            $target = $redirect->{$toCol};

            // Use away() for full URLs, redirect() for paths
            if (str_starts_with($target, 'http://') || str_starts_with($target, 'https://')) {
                return redirect()->away($target, $redirect->status_code);
            }

            return redirect($target, $redirect->status_code);
        }

        return $next($request);
    }
}
