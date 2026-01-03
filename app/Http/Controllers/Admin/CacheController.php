<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CacheController extends Controller
{
    /**
     * Display cache management page
     */
    public function index()
    {
        $cacheInfo = $this->getCacheInfo();
        return view('admin.cache.index', compact('cacheInfo'));
    }

    /**
     * Clear all caches
     */
    public function clearAll(Request $request)
    {
        try {
            $results = [];

            // Clear config cache
            Artisan::call('config:clear');
            $results[] = 'Config cache cleared';

            // Clear route cache
            Artisan::call('route:clear');
            $results[] = 'Route cache cleared';

            // Clear view cache
            Artisan::call('view:clear');
            $results[] = 'View cache cleared';

            // Clear application cache
            Artisan::call('cache:clear');
            $results[] = 'Application cache cleared';

            // Clear compiled classes
            Artisan::call('clear-compiled');
            $results[] = 'Compiled classes cleared';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'All caches cleared successfully!',
                    'results' => $results
                ]);
            }

            return redirect()->back()->with('success', 'All caches cleared successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error clearing cache: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear specific cache type
     */
    public function clearSpecific(Request $request, $type)
    {
        try {
            $message = '';

            switch ($type) {
                case 'config':
                    Artisan::call('config:clear');
                    $message = 'Config cache cleared';
                    break;

                case 'route':
                    Artisan::call('route:clear');
                    $message = 'Route cache cleared';
                    break;

                case 'view':
                    Artisan::call('view:clear');
                    $message = 'View cache cleared';
                    break;

                case 'cache':
                    Artisan::call('cache:clear');
                    $message = 'Application cache cleared';
                    break;

                case 'compiled':
                    Artisan::call('clear-compiled');
                    $message = 'Compiled classes cleared';
                    break;

                default:
                    throw new \Exception('Invalid cache type');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Rebuild caches for production
     */
    public function rebuild(Request $request)
    {
        try {
            $results = [];

            // Clear first
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            // Rebuild
            if (config('app.env') === 'production') {
                Artisan::call('config:cache');
                $results[] = 'Config cached';

                Artisan::call('route:cache');
                $results[] = 'Routes cached';

                Artisan::call('view:cache');
                $results[] = 'Views cached';
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cache rebuilt successfully!',
                    'results' => $results
                ]);
            }

            return redirect()->back()->with('success', 'Cache rebuilt successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error rebuilding cache: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error rebuilding cache: ' . $e->getMessage());
        }
    }

    /**
     * Get cache information
     */
    private function getCacheInfo()
    {
        return [
            'config' => [
                'exists' => File::exists(base_path('bootstrap/cache/config.php')),
                'size' => File::exists(base_path('bootstrap/cache/config.php')) 
                    ? File::size(base_path('bootstrap/cache/config.php')) 
                    : 0,
            ],
            'routes' => [
                'exists' => File::exists(base_path('bootstrap/cache/routes-v7.php')),
                'size' => File::exists(base_path('bootstrap/cache/routes-v7.php')) 
                    ? File::size(base_path('bootstrap/cache/routes-v7.php')) 
                    : 0,
            ],
            'views' => [
                'count' => count(File::files(storage_path('framework/views'))),
                'size' => $this->getDirectorySize(storage_path('framework/views')),
            ],
            'cache' => [
                'count' => $this->countCacheFiles(),
                'size' => $this->getDirectorySize(storage_path('framework/cache')),
            ],
            'build' => [
                'exists' => File::exists(public_path('build/manifest.json')),
                'manifest' => File::exists(public_path('build/manifest.json')) 
                    ? json_decode(File::get(public_path('build/manifest.json')), true) 
                    : null,
            ],
        ];
    }

    /**
     * Get directory size
     */
    private function getDirectorySize($path)
    {
        if (!File::exists($path)) {
            return 0;
        }

        $size = 0;
        foreach (File::allFiles($path) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    /**
     * Count cache files
     */
    private function countCacheFiles()
    {
        $path = storage_path('framework/cache/data');
        if (!File::exists($path)) {
            return 0;
        }

        return count(File::allFiles($path));
    }
}
