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

        // Skip admin, asset, and internal paths for performance
        if (str_starts_with($path, 'admin') || str_starts_with($path, '_debugbar') || str_starts_with($path, 'livewire')) {
            return $next($request);
        }

        // Check if there is a redirect for this path (cached to avoid DB hit per request)
        $redirect = Cache::remember("redirect_{$path}", 3600, function () use ($path) {
            $fromCol = Redirect::getFromColumn();

            $result = Redirect::where(function ($query) use ($fromCol, $path) {
                $query->where($fromCol, $path)
                    ->orWhere($fromCol, '/' . $path)
                    ->orWhere($fromCol, $path . '/')
                    ->orWhere($fromCol, '/' . $path . '/');
            })
                ->where('is_active', true)
                ->first();

            return $result ?? '__none__';
        });

        if ($redirect && $redirect !== '__none__') {
            try {
                $redirect->increment('hit_count');
            } catch (\Throwable $e) {
                // Ignore errors to not break the redirect
            }

            $toCol = Redirect::getToColumn();
            $target = $redirect->{$toCol};

            if (str_starts_with($target, 'http://') || str_starts_with($target, 'https://')) {
                return redirect()->away($target, $redirect->status_code);
            }

            return redirect($target, $redirect->status_code);
        }

        return $next($request);
    }
}

