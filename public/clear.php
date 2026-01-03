<?php
// Simple cache clear script for shared hosting
$laravelPath = __DIR__.'/../laravel-app'; // Adjust this to match your Laravel installation path

// Clear route cache
$routeCachePath = $laravelPath . '/bootstrap/cache/routes-v7.php';
if (file_exists($routeCachePath)) {
    unlink($routeCachePath);
    echo "✓ Route cache cleared<br>";
} else {
    echo "✓ Route cache already clear<br>";
}

// Clear config cache
$configCachePath = $laravelPath . '/bootstrap/cache/config.php';
if (file_exists($configCachePath)) {
    unlink($configCachePath);
    echo "✓ Config cache cleared<br>";
} else {
    echo "✓ Config cache already clear<br>";
}

// Clear view cache
$viewCachePath = $laravelPath . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ View cache cleared<br>";
}

// Clear application cache
$cachePath = $laravelPath . '/storage/framework/cache/data';
if (is_dir($cachePath)) {
    $files = glob($cachePath . '/*/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Application cache cleared<br>";
}

echo "<br><strong>All caches cleared successfully!</strong><br>";
echo "<a href='/'>← Back to Home</a>";
