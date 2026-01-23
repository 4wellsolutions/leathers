<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(prepend: [
            \App\Http\Middleware\CheckRedirects::class,
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (\Throwable $e) {
            if (app()->environment('production')) {
                try {
                    \Illuminate\Support\Facades\Mail::to('4wellsolutions@gmail.com')
                        ->send(new \App\Mail\ServerError($e, [
                            'url' => request()->fullUrl(),
                            'method' => request()->method(),
                            'ip' => request()->ip(),
                        ]));
                } catch (\Throwable $mailError) {
                    \Illuminate\Support\Facades\Log::error('Failed to send error email: ' . $mailError->getMessage());
                }
            }
        });
    })
    ->withSchedule(function ($schedule) {
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();
    })
    ->create();
